<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
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

        // Show the form
        return view('student.pre_assessment_form', compact('assessment', 'student'));
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
            'full_name'            => 'required|string|max:255',
            'contact_number'       => 'required|string|max:30',
            'contact_address'      => 'required|string',
            'dob'                  => 'required|date',
            'gender'               => 'required|string',
            'nationality'          => 'required|string',
            'passport_number'      => 'nullable|string|max:100',
            'highest_qualification'=> 'required|string',
            'name_of_institution'  => 'required|string|max:255',
            'year_of_passing'      => 'required|string|max:50',
            'second_qualification' => 'nullable|string',
            'second_institution'   => 'nullable|string',
            'second_year_of_passing'=> 'nullable|string',
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

        $assessment->update(array_merge(
            $request->only([
                'full_name', 'contact_number', 'contact_address', 'dob', 'passport_number', 'gender', 'nationality',
                'highest_qualification', 'grades_gpa', 'field_of_study',
                'name_of_institution', 'year_of_passing',
                'second_qualification', 'second_qual_grade', 'second_institution', 'second_year_of_passing',
                'english_proficiency', 'english_test', 'english_score', 'english_test_details', 'work_experience',
                'intended_course', 'course_link', 'level_of_study', 'preferred_intake',
                'study_method', 'study_destination', 'country_of_choice',
                'purpose_of_study', 'financial_source', 'source_of_funding',
                'visa_refusal_history', 'previous_uk_study_history'
            ]),
            ['assessment_status' => 'pending'] // Set back to pending upon edit
        ));

        return redirect()->route('pre.assessment.index')->with('success', 'Your pre-assessment form has been submitted and is under review.');
    }
}
