<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LetterTemplate;
use App\Models\DropdownOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class LetterTemplateController extends Controller
{
    /**
     * Helper to get list of dynamic letter types.
     */
    private function getLetterTypes(): array
    {
        $dynamicTypes = DropdownOption::active('letter_type');
        $existingTypes = LetterTemplate::select('type')->whereNotNull('type')->distinct()->pluck('type')->toArray();
        
        $merged = array_unique(array_merge($dynamicTypes, $existingTypes));
        sort($merged);
        return array_values($merged);
    }

    /**
     * Display a listing of letter templates.
     */
    public function index(Request $request)
    {
        $query = LetterTemplate::query();

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
        $types = $this->getLetterTypes();

        return view('backend.letter_templates.index', compact('templates', 'types'));
    }

    private function getStudentFields(): array
    {
        return [
            'Profile Info' => [
                'full_name' => 'Full Name',
                'title' => 'Title',
                'first_name' => 'First Name',
                'middle_name' => 'Middle Name',
                'surname' => 'Surname',
                'student_id' => 'Student ID',
                'email' => 'Email',
                'phone' => 'Phone',
                'dob' => 'Date of Birth',
                'gender' => 'Gender',
                'nationality' => 'Nationality',
                'country_of_birth' => 'Country of Birth',
                'skype_id' => 'Skype ID',
            ],
            'Address Info' => [
                'permanent_address' => 'Permanent Address',
                'permanent_city' => 'Permanent City',
                'permanent_postcode' => 'Permanent Postcode',
                'permanent_country' => 'Permanent Country',
                'current_address' => 'Current Address',
                'current_city' => 'Current City',
                'current_postcode' => 'Current Postcode',
                'current_country' => 'Current Country',
            ],
            'Passport & Travel Info' => [
                'name_in_passport' => 'Name in Passport',
                'passport_number' => 'Passport Number',
                'passport_issue_date' => 'Passport Issue Date',
                'passport_expiry_date' => 'Passport Expiry Date',
                'passport_issue_location' => 'Passport Issue Location',
            ]
        ];
    }

    /**
     * Show the form for creating a new letter template.
     */
    public function create()
    {
        $types = $this->getLetterTypes();
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        $tags = \App\Models\Tag::all();
        $studentFields = $this->getStudentFields();
        return view('backend.letter_templates.create', compact('types', 'officialSignatures', 'tags', 'studentFields'));
    }

    /**
     * Store a newly created letter template in storage.
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
                ['category' => 'letter_type', 'label' => $finalType],
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
            $data['header_image'] = $request->file('header_image')->store('letter_headers', 'public');
        }

        if ($request->hasFile('footer_image')) {
            $data['footer_image'] = $request->file('footer_image')->store('letter_footers', 'public');
        }

        LetterTemplate::create($data);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template created successfully!');
    }

    /**
     * Show the form for editing the specified letter template.
     */
    public function edit(LetterTemplate $letterTemplate)
    {
        $types = $this->getLetterTypes();
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        $tags = \App\Models\Tag::all();
        $studentFields = $this->getStudentFields();
        return view('backend.letter_templates.edit', compact('letterTemplate', 'types', 'officialSignatures', 'tags', 'studentFields'));
    }

    /**
     * Update the specified letter template in storage.
     */
    public function update(Request $request, LetterTemplate $letterTemplate)
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
                ['category' => 'letter_type', 'label' => $finalType],
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
            if ($letterTemplate->header_image && Storage::disk('public')->exists($letterTemplate->header_image)) {
                Storage::disk('public')->delete($letterTemplate->header_image);
            }
            $data['header_image'] = $request->file('header_image')->store('letter_headers', 'public');
        }

        if ($request->hasFile('footer_image')) {
            if ($letterTemplate->footer_image && Storage::disk('public')->exists($letterTemplate->footer_image)) {
                Storage::disk('public')->delete($letterTemplate->footer_image);
            }
            $data['footer_image'] = $request->file('footer_image')->store('letter_footers', 'public');
        }

        $letterTemplate->update($data);

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template updated successfully!');
    }

    /**
     * Remove the specified letter template from storage.
     */
    public function destroy(LetterTemplate $letterTemplate)
    {
        if ($letterTemplate->header_image && Storage::disk('public')->exists($letterTemplate->header_image)) {
            Storage::disk('public')->delete($letterTemplate->header_image);
        }
        if ($letterTemplate->footer_image && Storage::disk('public')->exists($letterTemplate->footer_image)) {
            Storage::disk('public')->delete($letterTemplate->footer_image);
        }

        $letterTemplate->delete();

        return redirect()->route('admin.letter-templates.index')
            ->with('success', 'Letter template deleted successfully!');
    }

    /**
     * Toggle status of template.
     */
    public function toggleStatus(LetterTemplate $letterTemplate)
    {
        $letterTemplate->status = $letterTemplate->status ? 0 : 1;
        $letterTemplate->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'status'  => (bool) $letterTemplate->status,
                'message' => 'Status updated successfully.'
            ]);
        }

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Render live preview with dummy data.
     */
    public function preview(LetterTemplate $letterTemplate)
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

        $content = $letterTemplate->content_body;
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

        return view('backend.letter_templates.preview', compact('letterTemplate', 'content', 'activeSignatures'));
    }
}
