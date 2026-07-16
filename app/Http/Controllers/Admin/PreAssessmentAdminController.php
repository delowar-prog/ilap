<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentPreAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreAssessmentAdminController extends Controller
{
    /** List all submissions with filter by status */
    public function index(Request $request)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $status      = $request->get('status', 'pending');
        
        $query = StudentPreAssessment::with(['student.user'])
            ->where('assessment_status', $status)
            ->whereHas('student', function ($q) {
                $q->whereNull('enrolment_status');
            });

        $assessments = $query->latest()->paginate(20);

        $counts = [
            'pending'  => StudentPreAssessment::where('assessment_status', 'pending')
                            ->whereHas('student', fn($q) => $q->whereNull('enrolment_status'))->count(),
            'approved' => StudentPreAssessment::where('assessment_status', 'approved')
                            ->whereHas('student', fn($q) => $q->whereNull('enrolment_status'))->count(),
            'rejected' => StudentPreAssessment::where('assessment_status', 'rejected')
                            ->whereHas('student', fn($q) => $q->whereNull('enrolment_status'))->count(),
        ];

        return view('backend.pre_assessment.index', compact('assessments', 'status', 'counts'));
    }

    /** Show full assessment details */
    public function show($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::with(['student.user', 'approvedBy'])->findOrFail($id);
        $student = $assessment->student;
        
        $academics = \App\Models\StudentAcademic::where('student_id', $student->id)->get();
        $englishTests = \App\Models\StudentEnglishTest::where('student_id', $student->id)->get();
        $referees = \App\Models\StudentReferee::where('student_id', $student->id)->get();
        $documents = \App\Models\StudentDocument::where('student_id', $student->id)->get();
        
        // Calculate Completion Percentage
        $completionPercent = 10;
        if ($student->phone && $student->current_address && $student->dob && $student->nationality) { $completionPercent += 30; }
        elseif ($student->phone || $student->current_address) { $completionPercent += 15; }
        if ($academics->count() > 0) { $completionPercent += 20; }
        if ($englishTests->count() > 0 || $student->native_language) { $completionPercent += 20; }
        if ($referees->count() > 0) { $completionPercent += 10; }
        if ($documents->count() > 0) { $completionPercent += 10; }
        $completionPercent = min($completionPercent, 100);

        return view('backend.pre_assessment.show', compact(
            'assessment', 
            'student',
            'academics',
            'englishTests',
            'referees',
            'documents',
            'completionPercent'
        ));
    }

    /** Approve an assessment */
    public function approve(Request $request, $id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');
        
        $request->validate([
            'selected_form' => 'required|string',
            'mandatory_documents' => 'nullable|array',
        ]);

        $assessment = StudentPreAssessment::findOrFail($id);
        $assessment->update([
            'assessment_status'   => 'approved',
            'approved_by'         => Auth::id(),
            'approved_at'         => now(),
            'rejection_note'      => null,
            'selected_form'       => $request->selected_form,
            'mandatory_documents' => $request->mandatory_documents,
        ]);

        // Auto-populate Student Profile
        $student = $assessment->student;
        if ($student) {
            // 1. Personal Information
            $student->update([
                'phone'             => $assessment->contact_number,
                'current_address'   => $assessment->contact_address,
                'dob'               => $assessment->dob,
                'gender'            => $assessment->gender,
                'nationality'       => $assessment->nationality,
                'passport_number'   => $assessment->passport_number,
            ]);

            // 2. Academic Information (Highest Qualification)
            if ($assessment->highest_qualification) {
                // Determine year mapping
                $awardDate = null;
                if ($assessment->year_of_passing && is_numeric($assessment->year_of_passing)) {
                    $awardDate = $assessment->year_of_passing . '-01-01';
                }

                $student->academics()->updateOrCreate(
                    [
                        'education_level'  => $assessment->highest_qualification,
                        'institution_name' => $assessment->name_of_institution,
                    ],
                    [
                        'course_name'      => $assessment->field_of_study,
                        'award_date'       => $awardDate,
                        'gpa'              => $assessment->grades_gpa,
                    ]
                );
            }

            // Academic Information (Second Qualification)
            if ($assessment->second_qualification) {
                $awardDate2 = null;
                if ($assessment->second_year_of_passing && is_numeric($assessment->second_year_of_passing)) {
                    $awardDate2 = $assessment->second_year_of_passing . '-01-01';
                }

                $student->academics()->updateOrCreate(
                    [
                        'education_level'  => $assessment->second_qualification,
                        'institution_name' => $assessment->second_institution,
                    ],
                    [
                        'award_date'       => $awardDate2,
                        'gpa'              => $assessment->second_qual_grade ?? null,
                    ]
                );
            }

            // 3. English Proficiency
            if ($assessment->english_proficiency && strtolower($assessment->english_proficiency) !== 'none') {
                $student->englishTests()->updateOrCreate(
                    [
                        'test_name' => $assessment->english_proficiency,
                    ],
                    [
                        'overall_score' => $assessment->english_score,
                    ]
                );
            }
        }

        return back()->with('success', "Student '{$assessment->full_name}' has been approved and profile auto-populated.");
    }

    /** Reject an assessment */
    public function reject(Request $request, $id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $request->validate(['rejection_note' => 'required|string|max:1000']);

        $assessment = StudentPreAssessment::findOrFail($id);
        $assessment->update([
            'assessment_status' => 'rejected',
            'approved_by'       => Auth::id(),
            'approved_at'       => now(),
            'rejection_note'    => $request->rejection_note,
        ]);

        return back()->with('success', "Student '{$assessment->full_name}' application has been rejected.");
    }

    /** Send to Pre-Enrolment */
    public function sendToPreEnrolment($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::findOrFail($id);
        
        if ($assessment->assessment_status !== 'approved') {
            return back()->with('error', "Only approved pre-assessments can be sent to pre-enrolment.");
        }

        if ($assessment->student) {
            $assessment->student->update([
                'enrolment_status' => 'pending'
            ]);
        }

        return redirect()->route('admin.pre.assessments.index')->with('success', "Student '{$assessment->full_name}' has been moved to Pre-Enrolment.");
    }
}
