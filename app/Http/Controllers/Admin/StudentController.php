<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentDocument;
use App\Models\StudentEnglishTest;
use App\Models\StudentPreAssessment;
use App\Models\StudentReferee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $allowedSorts = ['created_at', 'first_name', 'surname', 'email', 'phone', 'student_id'];
        if (! in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])
            ->where('enrolment_status', $status);

        if ($search) {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $students = $studentsQuery->orderBy($sortBy, $sortDir)->paginate($perPage)->withQueryString();

        $counts = [
            'pending' => Student::where('enrolment_status', 'pending')->count(),
            'approved' => Student::where('enrolment_status', 'approved')->count(),
            'rejected' => Student::where('enrolment_status', 'rejected')->count(),
        ];

        return view('backend.admin.students.index', compact('students', 'status', 'counts', 'search', 'sortBy', 'sortDir', 'perPage'));
    }

    public function show($id)
    {
        $student = Student::findOrFail($id);
        $preAssessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);
        $academics = StudentAcademic::where('student_id', $student->id)->get();
        $englishTests = StudentEnglishTest::where('student_id', $student->id)->get();
        $referees = StudentReferee::where('student_id', $student->id)->get();
        $documents = StudentDocument::where('student_id', $student->id)->get();

        // Calculate Completion Percentage
        $completionPercent = $student->getCompletionPercentage();

        $letterTemplates = \App\Models\LetterTemplate::where('status', 1)->get();
        $letterHistory = \App\Models\GeneratedLetter::where('student_id', $student->id)->with('generator')->latest()->get();

        $invoiceTemplates = \App\Models\InvoiceTemplate::where('status', 1)->get();
        $invoiceHistory = \App\Models\GeneratedInvoice::where('student_id', $student->id)->with('generator')->latest()->get();

        return view('backend.admin.students.show', compact(
            'student',
            'preAssessment',
            'academics',
            'englishTests',
            'referees',
            'documents',
            'completionPercent',
            'letterTemplates',
            'letterHistory',
            'invoiceTemplates',
            'invoiceHistory'
        ));
    }

    public function approve($id)
    {
        $student = Student::findOrFail($id);

        $student->enrolment_status = 'approved';
        $student->save();

        $msg = "Student '{$student->first_name}' pre-enrolment approved.";
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    public function reject($id)
    {
        $student = Student::findOrFail($id);
        $student->enrolment_status = 'rejected';
        $student->save();

        $msg = 'Pre-Enrolment rejected.';
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function enrolledStudents(Request $request)
    {
        $search = $request->get('search', '');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $allowedSorts = ['created_at', 'first_name', 'surname', 'email', 'phone', 'student_id'];
        if (! in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        $sortDir = $sortDir === 'asc' ? 'asc' : 'desc';

        $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])
            ->where('enrolment_status', 'enrolled');

        if ($search) {
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('surname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $students = $studentsQuery->orderBy($sortBy, $sortDir)->paginate($perPage)->withQueryString();

        return view('backend.admin.students.enrolled', compact('students', 'search', 'sortBy', 'sortDir', 'perPage'));
    }

    public function sendToStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->enrolment_status === 'approved') {
            $completionPercent = $student->getCompletionPercentage();
            if ($completionPercent < 100) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Cannot enrol student. Profile is only {$completionPercent}% complete. It must be 100% complete to proceed.",
                    ], 400);
                }

                return redirect()->back()->with('error', "Cannot enrol student. Profile is only {$completionPercent}% complete. It must be 100% complete to proceed.");
            }

            // If they still have an Applicant ID, upgrade it to a Student ID
            if (str_starts_with($student->student_id, 'APP')) {
                $yearMonth = date('ym');
                $count = Student::where('student_id', 'like', 'ST'.$yearMonth.'%')->count() + 1;
                $serial = str_pad($count, 2, '0', STR_PAD_LEFT);
                $initialFirstName = strtoupper(substr($student->first_name ?? 'X', 0, 1));
                $initialLastName = strtoupper(substr($student->surname ?? 'X', 0, 1));
                $newStudentId = 'ST'.$yearMonth.$serial.$initialFirstName.$initialLastName;
                $student->student_id = $newStudentId;
            }

            $student->enrolment_status = 'enrolled';
            $student->save();

            $msg = 'Student data moved to Enrolled Students successfully. ID: '.$student->student_id;
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                ]);
            }

            return redirect()->back()->with('success', $msg);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Student must be approved in Pre-Enrolment first.',
            ], 400);
        }

        return redirect()->back()->with('error', 'Student must be approved in Pre-Enrolment first.');
    }

    public function revertToPending($id)
    {
        $student = Student::findOrFail($id);
        if ($student->enrolment_status !== 'rejected') {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only rejected pre-enrolments can be reverted.',
                ], 400);
            }

            return back()->with('error', 'Only rejected pre-enrolments can be reverted.');
        }
        $student->enrolment_status = 'pending';
        $student->save();

        $msg = 'Pre-Enrolment reverted to pending.';
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $user = $student->user;
        $name = $student->first_name;

        $student->delete();
        if ($user) {
            $user->delete();
        }

        $msg = "Student '{$name}' has been successfully deleted.";
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return back()->with('success', $msg);
    }

    public function downloadProfilePdf($id)
    {
        $student = Student::findOrFail($id);
        $academics = $student->academics;
        $englishTests = $student->englishTests;
        $referees = $student->referees;

        $pdf = Pdf::loadView('backend.admin.students.profile_pdf', compact('student', 'academics', 'englishTests', 'referees'));
        $pdf->setPaper('a4', 'portrait');

        $cleanName = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', trim($student->first_name.' '.$student->surname)));
        $filename = $cleanName.'-'.$student->student_id.'.pdf';

        return $pdf->download($filename);
    }
}
