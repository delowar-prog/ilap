<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DropdownOption;
use App\Models\StudentAcademic;
use App\Models\StudentDocument;
use App\Models\StudentEnglishTest;
use App\Models\StudentPreAssessment;
use App\Models\StudentReferee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreAssessmentAdminController extends Controller
{
    /** List all submissions with filter by status */
    public function index(Request $request)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $status = $request->get('status', 'pending');
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'updated_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $allowedSorts = ['updated_at', 'created_at', 'full_name', 'contact_number'];
        if (! in_array($sortBy, $allowedSorts)) {
            $sortBy = 'updated_at';
        }
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $query = StudentPreAssessment::with(['student.user'])
            ->where('assessment_status', $status)
            ->whereHas('student', function ($q) {
                $q->whereNull('enrolment_status');
            });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%")
                    ->orWhere('study_destination', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($sq) use ($search) {
                        $sq->where('email', 'like', "%{$search}%")
                            ->orWhere('first_name', 'like', "%{$search}%")
                            ->orWhere('surname', 'like', "%{$search}%");
                    });
            });
        }

        $assessments = $query->orderBy($sortBy, $sortDir)->paginate($perPage)->withQueryString();

        $counts = [
            'pending' => StudentPreAssessment::where('assessment_status', 'pending')
                ->whereHas('student', fn ($q) => $q->whereNull('enrolment_status'))->count(),
            'approved' => StudentPreAssessment::where('assessment_status', 'approved')
                ->whereHas('student', fn ($q) => $q->whereNull('enrolment_status'))->count(),
            'rejected' => StudentPreAssessment::where('assessment_status', 'rejected')
                ->whereHas('student', fn ($q) => $q->whereNull('enrolment_status'))->count(),
        ];

        return view('backend.pre_assessment.index', compact('assessments', 'status', 'counts', 'search', 'sortBy', 'sortDir', 'perPage'));
    }

    /** Show full assessment details */
    public function show($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::with(['student.user', 'approvedBy'])->findOrFail($id);
        $student = $assessment->student;

        $academics = StudentAcademic::where('student_id', $student->id)->get();
        $englishTests = StudentEnglishTest::where('student_id', $student->id)->get();
        $referees = StudentReferee::where('student_id', $student->id)->get();
        $documents = StudentDocument::where('student_id', $student->id)->get();

        // Calculate Completion Percentage
        $completionPercent = $student->getCompletionPercentage();
        $departments = DropdownOption::active('department');
        $docOptions = DropdownOption::active('document_type');

        return view('backend.pre_assessment.show', compact(
            'assessment',
            'student',
            'academics',
            'englishTests',
            'referees',
            'documents',
            'completionPercent',
            'departments',
            'docOptions'
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

        // Filter mandatory_documents to only keep M and N statuses
        $rawDocs = $request->input('mandatory_documents', []);
        $mandatoryDocs = [];
        foreach ($rawDocs as $docType => $status) {
            if ($status === 'M' || $status === 'N') {
                $mandatoryDocs[$docType] = $status;
            }
        }

        $assessment = StudentPreAssessment::findOrFail($id);
        $assessment->update([
            'assessment_status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_note' => null,
            'selected_form' => $request->selected_form,
            'mandatory_documents' => $mandatoryDocs,
        ]);

        // Auto-populate Student Profile
        $student = $assessment->student;
        if ($student) {
            // 1. Personal Information
            $student->update([
                'first_name' => $assessment->first_name ?? $student->first_name,
                'middle_name' => $assessment->middle_name ?? $student->middle_name,
                'surname' => $assessment->surname ?? $student->surname,
                'phone' => $assessment->contact_number,
                'current_address' => $assessment->contact_address,
                'dob' => $assessment->dob,
                'gender' => $assessment->gender,
                'nationality' => $assessment->nationality,
                'passport_number' => $assessment->passport_number,

                // Travel & Immigration
                'travel_history' => $assessment->travel_history,
                'immigration_history' => $assessment->immigration_history,
                'visa_refusals' => $assessment->visa_refusals,
                'applied_leave_to_remain_uk' => ($assessment->travel_history['has_history'] ?? 'no') === 'yes' ? 1 : 0,
                'need_visa_for_uk' => in_array('None', $assessment->immigration_history['countries'] ?? ['None']) ? 0 : 1,
                'refused_visa_or_deported' => ($assessment->visa_refusals['has_refusal'] ?? 'no') === 'yes' ? 1 : 0,
            ]);

            // 2. Academic Information (Highest Qualification)
            if ($assessment->highest_qualification) {
                // Determine year mapping
                $awardDate = null;
                if ($assessment->year_of_passing && is_numeric($assessment->year_of_passing)) {
                    $awardDate = $assessment->year_of_passing.'-01-01';
                }

                $student->academics()->updateOrCreate(
                    [
                        'education_level' => $assessment->highest_qualification,
                        'institution_name' => $assessment->name_of_institution,
                    ],
                    [
                        'course_name' => $assessment->field_of_study,
                        'award_date' => $awardDate,
                        'gpa' => $assessment->grades_gpa,
                    ]
                );
            }

            // Academic Information (Second Qualification or Additional Qualifications)
            if (! empty($assessment->additional_qualifications) && is_array($assessment->additional_qualifications)) {
                foreach ($assessment->additional_qualifications as $qual) {
                    if (! empty($qual['qualification'])) {
                        $awardDateAdd = null;
                        if (! empty($qual['year_of_passing']) && is_numeric($qual['year_of_passing'])) {
                            $awardDateAdd = $qual['year_of_passing'].'-01-01';
                        }

                        $student->academics()->updateOrCreate(
                            [
                                'education_level' => $qual['qualification'],
                                'institution_name' => $qual['institution'] ?? null,
                            ],
                            [
                                'course_name' => $qual['field_of_study'] ?? null,
                                'gpa' => $qual['grades_gpa'] ?? null,
                                'award_date' => $awardDateAdd,
                            ]
                        );
                    }
                }
            } elseif ($assessment->second_qualification) {
                $awardDate2 = null;
                if ($assessment->second_year_of_passing && is_numeric($assessment->second_year_of_passing)) {
                    $awardDate2 = $assessment->second_year_of_passing.'-01-01';
                }

                $student->academics()->updateOrCreate(
                    [
                        'education_level' => $assessment->second_qualification,
                        'institution_name' => $assessment->second_institution,
                    ],
                    [
                        'award_date' => $awardDate2,
                        'gpa' => $assessment->second_qual_grade ?? null,
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
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_note' => $request->rejection_note,
        ]);

        return back()->with('success', "Student '{$assessment->full_name}' application has been rejected.");
    }

    /** Send to Pre-Enrolment */
    public function sendToPreEnrolment($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::findOrFail($id);

        if ($assessment->assessment_status !== 'approved') {
            return back()->with('error', 'Only approved pre-assessments can be sent to pre-enrolment.');
        }

        if ($assessment->student) {
            $student = $assessment->student;
            $student->update([
                'enrolment_status' => 'pending',
            ]);
        }

        return redirect()->route('admin.pre.assessments.index')->with('success', "Student '{$assessment->full_name}' has been moved to Pre-Enrolment.");
    }

    /** Revert a rejected assessment to pending */
    public function revertToPending($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::findOrFail($id);

        if ($assessment->assessment_status !== 'rejected') {
            return back()->with('error', 'Only rejected pre-assessments can be reverted to pending.');
        }

        $assessment->update([
            'assessment_status' => 'pending',
            'rejection_note' => null,
            'approved_by' => null,
            'approved_at' => null,
        ]);

        return back()->with('success', "Pre-assessment for '{$assessment->full_name}' has been reverted to pending.");
    }

    /** Delete a pre-assessment */
    public function destroy($id)
    {
        abort_unless(Auth::user()->hasAnyRole(['Super Admin', 'Admin']), 403, 'Unauthorized action.');

        $assessment = StudentPreAssessment::findOrFail($id);
        $name = $assessment->full_name;
        $assessment->delete();

        return back()->with('success', "Pre-assessment for '{$name}' has been successfully deleted.");
    }
}
