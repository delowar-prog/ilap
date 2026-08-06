<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\LetterTemplate;
use App\Models\GeneratedLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class StudentLetterController extends Controller
{
    /**
     * Display a global archive list of all generated letters across all students.
     */
    public function globalHistory(Request $request)
    {
        $query = GeneratedLetter::with(['student', 'generator', 'template']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('letter_title', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                  });
            });
        }

        $letters = $query->latest()->paginate(15);

        return view('backend.letter_templates.history', compact('letters'));
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
                $html = '<div style="display: inline-block; text-align: center; margin: 10px 20px;">';
                
                $html .= '<div style="position: relative; display: inline-block; min-height: 50px; min-width: 150px;">';
                
                if ($offSig->signature_path && file_exists(public_path($offSig->signature_path))) {
                    $html .= '<img src="' . public_path($offSig->signature_path) . '" style="max-height: 60px; position: relative; z-index: 2; margin: 0 auto; display: block;" alt="Signature">';
                }
                
                if ($offSig->seal_path && file_exists(public_path($offSig->seal_path))) {
                    // Seal slightly offset and below signature visually
                    $html .= '<img src="' . public_path($offSig->seal_path) . '" style="max-height: 80px; opacity: 0.85; position: absolute; top: -15px; left: 50%; transform: translateX(-50%); z-index: 1;" alt="Seal">';
                }
                
                $html .= '</div>';
                
                $designationText = $offSig->designation ? $offSig->designation . ' Signature' : 'Signature';
                
                $html .= '<div style="border-top: 1.5px solid #003366; width: 170px; margin: 5px auto 3px auto;"></div>';
                $html .= '<div style="font-weight: bold; font-size: 11px; color: #003366; line-height: 1.2;">' . e($designationText) . '</div>';
                $html .= '</div>';
                
                $content = str_replace($offSig->tag, $html, $content);
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

        // Dynamic Database Tags Mapping
        $dbTags = \App\Models\Tag::all();
        foreach ($dbTags as $dbTag) {
            $rawColumn = $dbTag->tag_for ?? str_replace(['{{', '}}'], '', $dbTag->tag);
            // Only map it if we haven't already explicitly defined it above
            if (!array_key_exists($dbTag->tag, $placeholders)) {
                if ($rawColumn === 'full_name') {
                    $placeholders[$dbTag->tag] = $fullName;
                } else {
                    $placeholders[$dbTag->tag] = $student->$rawColumn ?? 'N/A';
                }
            }
        }

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    /**
     * Render dynamic live preview for modal.
     */
    public function previewModal(Request $request, Student $student)
    {
        $templateId = $request->query('template_id');
        $template = LetterTemplate::find($templateId);

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
     * Generate Letter (from Template OR from Uploaded DOCX/PDF/Image file).
     */
    public function generate(Request $request, Student $student)
    {
        $request->validate([
            'generation_type'    => 'required|in:template,file_upload',
            'letter_template_id' => 'required_if:generation_type,template',
            'uploaded_file'      => 'nullable|file|mimes:docx,pdf,jpg,jpeg,png|max:10240',
            'custom_content'     => 'nullable|string',
            'letter_action'      => 'nullable|in:download,send',
        ]);

        $action = $request->letter_action ?? 'download';

        if ($request->generation_type === 'template') {
            $template = LetterTemplate::findOrFail($request->letter_template_id);

            $contentBody = $request->filled('custom_content')
                ? $request->custom_content
                : $template->content_body;

            $parsedContent = $this->parsePlaceholders($contentBody, $student, true);
            $parsedSubject = $this->parsePlaceholders($template->subject ?? $template->title, $student, false);

            // Generate PDF
            $pdf = Pdf::loadView('backend.pdf.letter_layout', [
                'content'          => $parsedContent,
                'title'            => $parsedSubject,
                'header_image'     => $template->header_image,
                'footer_image'     => $template->footer_image,
                'student'          => $student,
                'activeSignatures' => $this->activeSignatures
            ]);

            $fileName = 'generated_letters/' . $student->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            // Save record in history
            $record = GeneratedLetter::create([
                'student_id'         => $student->id,
                'letter_template_id' => $template->id,
                'letter_title'       => $template->title,
                'file_path'          => $fileName,
                'file_type'          => 'pdf',
                'generated_by'       => auth()->id(),
                'sent_to_student'    => $action === 'send',
                'sent_at'            => $action === 'send' ? now() : null,
            ]);

            if ($action === 'send') {
                // Send only — do not download, just redirect back with success message
                return redirect()->route('admin.students.show', ['student' => $student->id, 'tab' => 'letters'])
                    ->with('success', 'Letter "' . $template->title . '" has been sent to student\'s profile successfully!');
            }

            // Download immediately
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

                $fileName = 'generated_letters/docx_' . $student->id . '_' . time() . '.docx';
                $outputPath = storage_path('app/public/' . $fileName);
                $templateProcessor->saveAs($outputPath);

                GeneratedLetter::create([
                    'student_id'         => $student->id,
                    'letter_template_id' => null,
                    'letter_title'       => 'Custom DOCX Letter (' . $file->getClientOriginalName() . ')',
                    'file_path'          => $fileName,
                    'file_type'          => 'docx',
                    'generated_by'       => auth()->id(),
                ]);

                return response()->download($outputPath);

            } else {
                // Image or PDF direct attachment/save
                $fileName = $file->store('generated_letters', 'public');

                GeneratedLetter::create([
                    'student_id'         => $student->id,
                    'letter_template_id' => null,
                    'letter_title'       => 'Uploaded Letter (' . $file->getClientOriginalName() . ')',
                    'file_path'          => $fileName,
                    'file_type'          => $ext,
                    'generated_by'       => auth()->id(),
                ]);

                return response()->download(storage_path('app/public/' . $fileName));
            }
        }

        return back()->with('error', 'Unable to generate letter. Please select a template or upload a file.');
    }

    /**
     * Download a previously generated letter.
     */
    public function downloadHistory(GeneratedLetter $generatedLetter)
    {
        if (Storage::disk('public')->exists($generatedLetter->file_path)) {
            return Storage::disk('public')->download($generatedLetter->file_path);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Preview a generated letter inline in browser.
     */
    public function previewLetter(GeneratedLetter $generatedLetter)
    {
        if (Storage::disk('public')->exists($generatedLetter->file_path)) {
            $filePath = storage_path('app/public/' . $generatedLetter->file_path);
            return response()->file($filePath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($generatedLetter->file_path) . '"',
            ]);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Mark an existing generated letter as sent to student.
     */
    public function sendToStudent(GeneratedLetter $generatedLetter)
    {
        $generatedLetter->update([
            'sent_to_student' => true,
            'sent_at'         => now(),
        ]);

        return back()->with('success', 'Letter "' . $generatedLetter->letter_title . '" has been sent to the student\'s profile successfully!');
    }

    /**
     * Delete generated letter record.
     */
    public function deleteHistory(GeneratedLetter $generatedLetter)
    {
        if (Storage::disk('public')->exists($generatedLetter->file_path)) {
            Storage::disk('public')->delete($generatedLetter->file_path);
        }

        $generatedLetter->delete();

        return back()->with('success', 'Letter history record deleted successfully.');
    }
}
