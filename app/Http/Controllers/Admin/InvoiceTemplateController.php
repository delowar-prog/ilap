<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvoiceTemplate;
use App\Models\DropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceTemplateController extends Controller
{
    /**
     * Helper to get list of dynamic invoice types.
     */
    private function getInvoiceTypes(): array
    {
        $dynamicTypes = DropdownOption::active('invoice_type');
        $existingTypes = InvoiceTemplate::select('type')->whereNotNull('type')->distinct()->pluck('type')->toArray();
        
        $merged = array_unique(array_merge($dynamicTypes, $existingTypes));
        sort($merged);
        return array_values($merged);
    }

    /**
     * Display a listing of invoice templates.
     */
    public function index(Request $request)
    {
        $query = InvoiceTemplate::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $templates = $query->latest()->paginate(10);
        $types = $this->getInvoiceTypes();

        return view('backend.invoice_templates.index', compact('templates', 'types'));
    }

    /**
     * Show the form for creating a new invoice template.
     */
    public function create()
    {
        $types = $this->getInvoiceTypes();
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        return view('backend.invoice_templates.create', compact('types', 'officialSignatures'));
    }

    /**
     * Store a newly created invoice template in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'type'         => 'required|string|max:100',
            'custom_type'  => 'nullable|string|max:100',
            'subject'      => 'nullable|string|max:255',
            'content_body' => 'required|string',
            'header_image' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:4096',
            'footer_image' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:4096',
            'status'       => 'nullable|boolean',
        ]);

        $finalType = ($request->type === 'other' || $request->type === 'add_new') && $request->filled('custom_type')
            ? trim($request->custom_type)
            : trim($request->type);

        // Auto-register new custom type in DropdownOption system
        if (!empty($finalType)) {
            DropdownOption::firstOrCreate(
                ['category' => 'invoice_type', 'label' => $finalType],
                ['sort_order' => 99, 'is_active' => true]
            );
        }

        $data = [
            'title'        => $request->title,
            'type'         => $finalType,
            'subject'      => $request->subject,
            'content_body' => $request->content_body,
            'status'       => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('header_image')) {
            $data['header_image'] = $request->file('header_image')->store('invoice_headers', 'public');
        }

        if ($request->hasFile('footer_image')) {
            $data['footer_image'] = $request->file('footer_image')->store('invoice_footers', 'public');
        }

        InvoiceTemplate::create($data);

        return redirect()->route('admin.invoice-templates.index')
            ->with('success', 'Invoice template created successfully!');
    }

    /**
     * Show the form for editing the specified invoice template.
     */
    public function edit(InvoiceTemplate $invoiceTemplate)
    {
        $types = $this->getInvoiceTypes();
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        return view('backend.invoice_templates.edit', compact('invoiceTemplate', 'types', 'officialSignatures'));
    }

    /**
     * Update the specified invoice template in storage.
     */
    public function update(Request $request, InvoiceTemplate $invoiceTemplate)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'type'         => 'required|string|max:100',
            'custom_type'  => 'nullable|string|max:100',
            'subject'      => 'nullable|string|max:255',
            'content_body' => 'required|string',
            'header_image' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:4096',
            'footer_image' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:4096',
            'status'       => 'nullable|boolean',
        ]);

        $finalType = ($request->type === 'other' || $request->type === 'add_new') && $request->filled('custom_type')
            ? trim($request->custom_type)
            : trim($request->type);

        if (!empty($finalType)) {
            DropdownOption::firstOrCreate(
                ['category' => 'invoice_type', 'label' => $finalType],
                ['sort_order' => 99, 'is_active' => true]
            );
        }

        $data = [
            'title'        => $request->title,
            'type'         => $finalType,
            'subject'      => $request->subject,
            'content_body' => $request->content_body,
            'status'       => $request->has('status') ? 1 : 0,
        ];

        if ($request->hasFile('header_image')) {
            if ($invoiceTemplate->header_image && Storage::disk('public')->exists($invoiceTemplate->header_image)) {
                Storage::disk('public')->delete($invoiceTemplate->header_image);
            }
            $data['header_image'] = $request->file('header_image')->store('invoice_headers', 'public');
        }

        if ($request->hasFile('footer_image')) {
            if ($invoiceTemplate->footer_image && Storage::disk('public')->exists($invoiceTemplate->footer_image)) {
                Storage::disk('public')->delete($invoiceTemplate->footer_image);
            }
            $data['footer_image'] = $request->file('footer_image')->store('invoice_footers', 'public');
        }

        $invoiceTemplate->update($data);

        return redirect()->route('admin.invoice-templates.index')
            ->with('success', 'Invoice template updated successfully!');
    }

    /**
     * Remove the specified invoice template from storage.
     */
    public function destroy(InvoiceTemplate $invoiceTemplate)
    {
        if ($invoiceTemplate->header_image && Storage::disk('public')->exists($invoiceTemplate->header_image)) {
            Storage::disk('public')->delete($invoiceTemplate->header_image);
        }
        if ($invoiceTemplate->footer_image && Storage::disk('public')->exists($invoiceTemplate->footer_image)) {
            Storage::disk('public')->delete($invoiceTemplate->footer_image);
        }

        $invoiceTemplate->delete();

        return redirect()->route('admin.invoice-templates.index')
            ->with('success', 'Invoice template deleted successfully!');
    }

    /**
     * Toggle status of template.
     */
    public function toggleStatus(InvoiceTemplate $invoiceTemplate)
    {
        $invoiceTemplate->status = $invoiceTemplate->status ? 0 : 1;
        $invoiceTemplate->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'status'  => (bool) $invoiceTemplate->status,
                'message' => 'Status updated successfully.'
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Render live preview with dummy data.
     */
    public function preview(InvoiceTemplate $invoiceTemplate)
    {
        $dummyData = [
            '{{student_name}}'     => 'John Doe',
            '{{student_id}}'       => 'STU-2026-001',
            '{{email}}'            => 'john.doe@example.com',
            '{{phone}}'            => '+880 1700-000000',
            '{{passport_number}}' => 'A12345678',
            '{{dob}}'              => '15 Jan, 2000',
            '{{today_date}}'       => date('d M, Y'),
            '{{institute_name}}'   => 'University of Oxford',
            '{{course_name}}'      => 'MSc in Computer Science',
            '{{session_name}}'     => 'Fall 2026',
            '{{tuition_fee}}'      => '$15,000 USD',
            '{{address}}'          => 'House 12, Road 5, Dhanmondi, Dhaka',
        ];

        $content = $invoiceTemplate->content_body;
        $activeSignatures = [];

        // Parse signature placeholders and replace with clean labels in text
        if (str_contains($content, '{{admin_signature}}')) {
            $activeSignatures[] = [
                'name'        => auth()->user()->name ?? 'Super Admin',
                'designation' => 'Admin',
                'dummy'       => true
            ];
            $content = str_replace('{{admin_signature}}', '<span style="font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; color: #333;">Admin Signature</span>', $content);
        }

        if (str_contains($content, '{{student_signature}}')) {
            $activeSignatures[] = [
                'name'        => 'John Doe',
                'designation' => 'Student',
                'dummy'       => true
            ];
            $content = str_replace('{{student_signature}}', '<span style="font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; color: #333;">Student Signature</span>', $content);
        }

        // Official active signatures
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        foreach ($officialSignatures as $offSig) {
            if (str_contains($content, $offSig->tag)) {
                $activeSignatures[] = [
                    'name'        => $offSig->name,
                    'designation' => $offSig->designation ?? 'Authorized Signatory',
                    'dummy'       => true
                ];
                $label = $offSig->type === 'seal' ? 'Official Seal' : ($offSig->name . ' - ' . ($offSig->designation ?? 'Authorized Signatory'));
                $content = str_replace($offSig->tag, '<span style="font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; color: #333;">' . e($label) . '</span>', $content);
            }
        }

        $content = str_replace(array_keys($dummyData), array_values($dummyData), $content);

        return view('backend.invoice_templates.preview', compact('invoiceTemplate', 'content', 'activeSignatures'));
    }
}
