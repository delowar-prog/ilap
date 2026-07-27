<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

use Illuminate\Support\Facades\Schema;

class TagController extends Controller
{
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
                'native_language' => 'Native Language',
                'skype_id' => 'Skype ID',
            ],
            'Address Info' => [
                'permanent_address' => 'Permanent Address',
                'permanent_city' => 'Permanent City',
                'permanent_state' => 'Permanent State',
                'permanent_postcode' => 'Permanent Postcode',
                'permanent_country' => 'Permanent Country',
                'current_address' => 'Current Address',
                'current_city' => 'Current City',
                'current_state' => 'Current State',
                'current_postcode' => 'Current Postcode',
                'current_country' => 'Current Country',
            ],
            'Passport & Travel Info' => [
                'name_in_passport' => 'Name in Passport',
                'passport_number' => 'Passport Number',
                'passport_issue_date' => 'Passport Issue Date',
                'passport_expiry_date' => 'Passport Expiry Date',
                'passport_issue_location' => 'Passport Issue Location',
            ],
            'Emergency Contact' => [
                'emergency_contact_name' => 'Emergency Contact Name',
                'emergency_contact_mobile' => 'Emergency Contact Mobile',
                'emergency_contact_email' => 'Emergency Contact Email',
                'emergency_contact_relationship' => 'Emergency Contact Relationship',
            ],
            'Immigration History' => [
                'applied_leave_to_remain_uk' => 'Applied Leave to Remain UK',
                'need_visa_for_uk' => 'Need Visa for UK',
                'refused_visa_or_deported' => 'Refused Visa or Deported',
                'taken_tb_test' => 'Taken TB Test',
            ]
        ];
    }

    public function index()
    {
        $tags = Tag::latest()->get();
        $studentFields = $this->getStudentFields();
        return view('backend.tags.index', compact('tags', 'studentFields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag_for' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'tag' => 'required|string|max:100|unique:tags,tag'
        ]);

        $tag = Tag::create([
            'tag_for' => $request->tag_for,
            'name' => $request->name,
            'tag' => '{{' . trim(str_replace(['{', '}'], '', $request->tag)) . '}}'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'tag' => $tag
            ]);
        }

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully');
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'tag_for' => 'required|string|max:100',
            'name' => 'required|string|max:255',
            'tag' => 'required|string|max:100|unique:tags,tag,' . $tag->id
        ]);

        $tag->update([
            'tag_for' => $request->tag_for,
            'name' => $request->name,
            'tag' => '{{' . trim(str_replace(['{', '}'], '', $request->tag)) . '}}'
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully');
    }
}
