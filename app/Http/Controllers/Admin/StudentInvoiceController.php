<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\InvoiceTemplate;
use App\Models\GeneratedInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class StudentInvoiceController extends Controller
{
    /**
     * Display a global archive list of all generated invoices across all students.
     */
    public function globalHistory(Request $request)
    {
        $query = GeneratedInvoice::with(['student', 'generator', 'template']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_title', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(15);

        return view('backend.invoice_templates.history', compact('invoices'));
    }

    public $activeSignatures = [];

    /**
     * Helper to replace placeholders with real student data.
     */
    private function parsePlaceholders(string $content, Student $student, bool $resetSignatures = false): string
    {
        if ($resetSignatures) {
            // Reset active signatures list for this parsing session
            $this->activeSignatures = [];
        }

        $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
        if (empty($fullName)) {
            $fullName = $student->name ?? 'Student';
        }

        $currentUser    = auth()->user();
        $issuerName     = $currentUser ? $currentUser->name : 'Authorized Signatory';
        $issuerDesig    = $currentUser?->roles?->first()?->name ?? 'Admin';

        // 1. Admin Signature
        if (str_contains($content, '{{admin_signature}}')) {
            if ($currentUser && $currentUser->signature && file_exists(public_path($currentUser->signature))) {
                $this->activeSignatures[] = [
                    'path'        => public_path($currentUser->signature),
                    'name'        => $issuerName,
                    'designation' => $issuerDesig,
                    'type'        => 'signature'
                ];
            }
            // Remove the inline tag — signature image shown via fixed block above footer
            $content = str_replace('{{admin_signature}}', '', $content);
        }

        // 2. Student Signature
        if (str_contains($content, '{{student_signature}}')) {
            $studentUser = $student->user ?? null;
            if ($studentUser && $studentUser->signature && file_exists(public_path($studentUser->signature))) {
                $studentFullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? '')) ?: ($student->name ?? 'Student');
                $this->activeSignatures[] = [
                    'path'        => public_path($studentUser->signature),
                    'name'        => $studentFullName,
                    'designation' => 'Student',
                    'type'        => 'signature'
                ];
            }
            // Remove the inline tag — signature image shown via fixed block above footer
            $content = str_replace('{{student_signature}}', '', $content);
        }

        // 3. Dynamic Official Signatures & Seals
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        foreach ($officialSignatures as $offSig) {
            if (str_contains($content, $offSig->tag)) {
                if (file_exists(public_path($offSig->signature_path))) {
                    $this->activeSignatures[] = [
                        'path'        => public_path($offSig->signature_path),
                        'name'        => $offSig->name,
                        'designation' => $offSig->designation ?? 'Authorized Signatory',
                        'type'        => $offSig->type // 'signature' or 'seal'
                    ];
                }
                
                $label = $offSig->type === 'seal' ? 'Official Seal' : ($offSig->name . ' - ' . ($offSig->designation ?? 'Authorized Signatory'));
                $content = str_replace($offSig->tag, '<span style="font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; color: #333;">' . e($label) . '</span>', $content);
            }
        }

        // Standard Placeholders
        $placeholders = [
            '{{student_name}}'      => $fullName,
            '{{student_id}}'        => $student->student_code ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)),
            '{{email}}'             => $student->email ?? 'N/A',
            '{{phone}}'             => $student->phone ?? 'N/A',
            '{{passport_number}}'   => $student->passport_number ?? 'N/A',
            '{{dob}}'               => $student->date_of_birth ? date('d M, Y', strtotime($student->date_of_birth)) : 'N/A',
            '{{gender}}'            => ucfirst($student->gender ?? 'N/A'),
            '{{nationality}}'       => $student->nationality ?? 'N/A',
            '{{today_date}}'        => date('d M, Y'),
            '{{institute_name}}'    => $student->institute?->name ?? 'N/A',
            '{{course_name}}'       => $student->course?->name ?? 'N/A',
            '{{address}}'           => $student->address ?? 'N/A',
            '{{issuer_name}}'       => $issuerName,
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    /**
     * Render dynamic live preview for modal.
     */
    public function previewModal(Request $request, Student $student)
    {
        $templateId = $request->query('template_id');
        $template = InvoiceTemplate::find($templateId);

        if (!$template) {
            return response()->json(['success' => false, 'html' => '<div class="alert alert-warning">Please select a valid template.</div>']);
        }

        $parsedContent = $this->parsePlaceholders($template->content_body, $student, true);

        return response()->json([
            'success' => true,
            'subject' => $this->parsePlaceholders($template->subject ?? '', $student, false),
            'content' => $parsedContent
        ]);
    }

    /**
     * Generate Invoice (from Template OR from Uploaded DOCX/PDF/Image file).
     */
    public function generate(Request $request, Student $student)
    {
        $request->validate([
            'generation_type'     => 'required|in:template,file_upload',
            'invoice_template_id' => 'required_if:generation_type,template',
            'uploaded_file'       => 'nullable|file|mimes:docx,pdf,jpg,jpeg,png|max:10240',
            'custom_content'      => 'nullable|string',
            'invoice_action'      => 'nullable|in:download,send',
        ]);

        $action = $request->invoice_action ?? 'download';

        if ($request->generation_type === 'template') {
            $template = InvoiceTemplate::findOrFail($request->invoice_template_id);

            $contentBody = $request->filled('custom_content')
                ? $request->custom_content
                : $template->content_body;

            $parsedContent = $this->parsePlaceholders($contentBody, $student, true);
            $parsedSubject = $this->parsePlaceholders($template->subject ?? $template->title, $student, false);

            // Generate PDF
            $pdf = Pdf::loadView('backend.pdf.invoice_layout', [
                'content'          => $parsedContent,
                'title'            => $parsedSubject,
                'header_image'     => $template->header_image,
                'footer_image'     => $template->footer_image,
                'student'          => $student,
                'activeSignatures' => $this->activeSignatures
            ]);

            $fileName = 'generated_invoices/' . $student->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            // Save record in history
            $record = GeneratedInvoice::create([
                'student_id'          => $student->id,
                'invoice_template_id' => $template->id,
                'invoice_title'       => $template->title,
                'file_path'           => $fileName,
                'file_type'           => 'pdf',
                'generated_by'        => auth()->id(),
                'sent_to_student'     => $action === 'send',
                'sent_at'             => $action === 'send' ? now() : null,
            ]);

            if ($action === 'send') {
                return redirect()->route('admin.students.show', $student->id)
                    ->with('success', 'Invoice "' . $template->title . '" has been sent to student\'s profile successfully!');
            }

            return response()->download(storage_path('app/public/' . $fileName));

        } else if ($request->hasFile('uploaded_file')) {
            $file = $request->file('uploaded_file');
            $ext = strtolower($file->getClientOriginalExtension());

            if ($ext === 'docx') {
                // Word Template processing using PHPWord
                $templateProcessor = new TemplateProcessor($file->getRealPath());

                $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
                if (empty($fullName)) {
                    $fullName = $student->name ?? 'Student';
                }

                $templateProcessor->setValue('student_name', $fullName);
                $templateProcessor->setValue('student_id', $student->student_code ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)));
                $templateProcessor->setValue('email', $student->email ?? '');
                $templateProcessor->setValue('phone', $student->phone ?? '');
                $templateProcessor->setValue('passport_number', $student->passport_number ?? '');
                $templateProcessor->setValue('today_date', date('d M, Y'));
                $templateProcessor->setValue('institute_name', $student->institute->name ?? '');
                $templateProcessor->setValue('course_name', $student->course->name ?? '');

                $fileName = 'generated_invoices/docx_' . $student->id . '_' . time() . '.docx';
                $outputPath = storage_path('app/public/' . $fileName);
                $templateProcessor->saveAs($outputPath);

                GeneratedInvoice::create([
                    'student_id'          => $student->id,
                    'invoice_template_id' => null,
                    'invoice_title'       => 'Custom DOCX Invoice (' . $file->getClientOriginalName() . ')',
                    'file_path'           => $fileName,
                    'file_type'           => 'docx',
                    'generated_by'        => auth()->id(),
                ]);

                return response()->download($outputPath);

            } else {
                // Image or PDF direct attachment/save
                $fileName = $file->store('generated_invoices', 'public');

                GeneratedInvoice::create([
                    'student_id'          => $student->id,
                    'invoice_template_id' => null,
                    'invoice_title'       => 'Uploaded Invoice (' . $file->getClientOriginalName() . ')',
                    'file_path'           => $fileName,
                    'file_type'           => $ext,
                    'generated_by'        => auth()->id(),
                    'sent_to_student'     => $action === 'send',
                    'sent_at'             => $action === 'send' ? now() : null,
                ]);

                if ($action === 'send') {
                    return redirect()->route('admin.students.show', $student->id)
                        ->with('success', 'Uploaded invoice has been sent to student\'s profile successfully!');
                }

                return response()->download(storage_path('app/public/' . $fileName));
            }
        }

        return back()->with('error', 'Unable to generate invoice. Please select a template or upload a file.');
    }

    /**
     * Download a previously generated invoice.
     */
    public function downloadHistory(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            return Storage::disk('public')->download($generatedInvoice->file_path);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Preview a generated invoice inline in browser.
     */
    public function previewInvoice(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            $filePath = storage_path('app/public/' . $generatedInvoice->file_path);
            return response()->file($filePath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($generatedInvoice->file_path) . '"',
            ]);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Mark an existing generated invoice as sent to student.
     */
    public function sendToStudent(GeneratedInvoice $generatedInvoice)
    {
        $generatedInvoice->update([
            'sent_to_student' => true,
            'sent_at'         => now(),
        ]);

        return back()->with('success', 'Invoice "' . $generatedInvoice->invoice_title . '" has been sent to the student\'s profile successfully!');
    }

    /**
     * Delete generated invoice record.
     */
    public function deleteHistory(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            Storage::disk('public')->delete($generatedInvoice->file_path);
        }

        $generatedInvoice->delete();

        return back()->with('success', 'Invoice history record deleted successfully.');
    }
}
