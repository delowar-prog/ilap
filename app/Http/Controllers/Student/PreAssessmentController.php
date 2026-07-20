<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DropdownOption;
use App\Models\Student;
use App\Models\StudentPreAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PreAssessmentController extends Controller
{
    /** Show the index/status page */
    public function index()
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('dashboard')->withErrors(['Please complete your registration.']);

        $assessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);

        // Allow approved students to see their status page
        if (!$assessment->isSubmitted()) {
            return redirect()->route('pre.assessment.show');
        }

        return view('student.pre_assessment_index', compact('assessment', 'student'));
    }

    /** Show the pre-assessment form (for new or editing) */
    public function show()
    {
        $student    = Auth::user()->student;
        if (!$student) return redirect()->route('dashboard')->withErrors(['Please complete your registration.']);

        $assessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);

        if ($assessment->isApproved()) {
            return redirect()->route('pre.assessment.index')->with('success', 'Your application is already approved and locked.');
        }

        // Dynamic dropdown options from admin configuration
        $studyDestinations     = DropdownOption::active('study_destination');
        $studyMethods          = DropdownOption::active('study_method');
        $levelOfStudyOptions   = DropdownOption::active('level_of_study');
        $qualificationOptions  = DropdownOption::active('highest_qualification');
        $financialSourceOptions = DropdownOption::active('financial_source');

        return view('student.pre_assessment_form', compact(
            'assessment', 'student',
            'studyDestinations', 'studyMethods',
            'levelOfStudyOptions', 'qualificationOptions',
            'financialSourceOptions'
        ));
    }

    /** Save the pre-assessment form for the first time */
    public function store(Request $request)
    {
        return $this->saveAssessment($request);
    }

    /** Update the pre-assessment form when in pending/rejected state */
    public function update(Request $request)
    {
        return $this->saveAssessment($request);
    }

    private function saveAssessment(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) return redirect()->route('dashboard');

        $assessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);

        // Don't allow modification if already approved
        if ($assessment->isApproved()) {
            return redirect()->route('student.dashboard');
        }

        $request->validate([
            'first_name'           => 'required|string|max:100',
            'middle_name'          => 'nullable|string|max:100',
            'surname'              => 'required|string|max:100',
            'contact_number'       => 'required|string|max:30',
            'contact_address'      => 'required|string',
            'city'                 => 'required|string|max:100',
            'state'                => 'required|string|max:100',
            'postal_code'          => 'required|string|max:50',
            'country'              => 'required|string|max:100',
            'dob'                  => 'required|date',
            'gender'               => 'required|string',
            'nationality'          => 'required|string',
            'passport_number'      => 'nullable|string|max:100',
            'highest_qualification'=> 'required|string',
            'highest_qualification_other' => 'required_if:highest_qualification,Other|nullable|string|max:255',
            'name_of_institution'  => 'required|string|max:255',
            'year_of_passing'      => 'required|string|max:50',
            'additional_qualifications' => 'nullable|array',
            'additional_qualifications.*.qualification' => 'required|string|max:255',
            'additional_qualifications.*.institution' => 'required|string|max:255',
            'additional_qualifications.*.year_of_passing' => 'required|string|max:100',
            'additional_qualifications.*.grades_gpa' => 'required|string|max:100',
            'additional_qualifications.*.field_of_study' => 'nullable|string|max:255',
            'english_proficiency'  => 'required|string',
            'english_score'        => 'nullable|string',
            'work_experience'      => 'nullable|string',
            'study_destination'    => 'required|string',
            'level_of_study'       => 'required|string',
            'intended_course'      => 'required|string|max:255',
            'preferred_intake'     => 'required|string',
            'financial_source'     => 'required|string',
            'visa_refusal_history' => 'required|string',
            'previous_uk_study_history' => 'required|string',
        ]);

        if ($request->highest_qualification === 'Other' && $request->filled('highest_qualification_other')) {
            $request->merge(['highest_qualification' => $request->highest_qualification_other]);
        }

        $fullName = trim($request->first_name . ' ' . ($request->middle_name ?? '') . ' ' . $request->surname);

        $additionalQuals = $request->input('additional_qualifications', []);
        $secondQual = null;
        $secondInst = null;
        $secondYear = null;
        $secondGrade = null;
        if (!empty($additionalQuals) && count($additionalQuals) > 0) {
            $secondQual = $additionalQuals[0]['qualification'] ?? null;
            $secondInst = $additionalQuals[0]['institution'] ?? null;
            $secondYear = $additionalQuals[0]['year_of_passing'] ?? null;
            $secondGrade = $additionalQuals[0]['grades_gpa'] ?? null;
        }

        $assessment->update(array_merge(
            $request->only([
                'first_name', 'middle_name', 'surname', 'contact_number', 'contact_address', 'city', 'state', 'postal_code', 'country', 'dob', 'passport_number', 'gender', 'nationality',
                'highest_qualification', 'grades_gpa', 'field_of_study',
                'name_of_institution', 'year_of_passing',
                'english_proficiency', 'english_test', 'english_score', 'english_test_details', 'work_experience',
                'intended_course', 'course_link', 'level_of_study', 'preferred_intake',
                'study_method', 'study_destination', 'country_of_choice',
                'purpose_of_study', 'financial_source', 'source_of_funding',
                'visa_refusal_history', 'previous_uk_study_history'
            ]),
            [
                'full_name' => $fullName,
                'second_qualification' => $secondQual,
                'second_institution' => $secondInst,
                'second_year_of_passing' => $secondYear,
                'second_qual_grade' => $secondGrade,
                'additional_qualifications' => $additionalQuals,
                'assessment_status' => 'pending'
            ] // Set back to pending upon edit
        ));

        return redirect()->route('pre.assessment.index')->with('success', 'Your pre-assessment form has been submitted and is under review.');
    }
}
