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
        $assessments = StudentPreAssessment::with(['student.user'])
            ->where('assessment_status', $status)
            ->latest()
            ->paginate(20);

        $counts = [
            'pending'  => StudentPreAssessment::where('assessment_status', 'pending')->count(),
            'approved' => StudentPreAssessment::where('assessment_status', 'approved')->count(),
            'rejected' => StudentPreAssessment::where('assessment_status', 'rejected')->count(),
        ];

        return view('backend.pre_assessment.index', compact('assessments', 'status', 'counts'));
    }

    /** Show full assessment details */
    public function show($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::with(['student.user', 'approvedBy'])->findOrFail($id);
        return view('backend.pre_assessment.show', compact('assessment'));
    }

    /** Approve an assessment */
    public function approve($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::findOrFail($id);
        $assessment->update([
            'assessment_status' => 'approved',
            'approved_by'       => Auth::id(),
            'approved_at'       => now(),
            'rejection_note'    => null,
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
}
