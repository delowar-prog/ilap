<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentEnglishTest;
use App\Models\StudentReferee;
use App\Models\StudentDocument;
use App\Models\StudentPreAssessment;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $status  = $request->get('status', 'pending');
        $search  = $request->get('search', '');
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $allowedSorts = ['created_at', 'first_name', 'surname', 'email', 'phone', 'student_id'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
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
            'pending'  => Student::where('enrolment_status', 'pending')->count(),
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
        $completionPercent = 10;
        if ($student->phone && $student->current_address && $student->dob && $student->nationality) { $completionPercent += 30; }
        elseif ($student->phone || $student->current_address) { $completionPercent += 15; }
        if ($academics->count() > 0) { $completionPercent += 20; }
        if ($englishTests->count() > 0 || $student->native_language) { $completionPercent += 20; }
        if ($referees->count() > 0) { $completionPercent += 10; }
        if ($documents->count() > 0) { $completionPercent += 10; }
        $completionPercent = min($completionPercent, 100);

        return view('backend.admin.students.show', compact(
            'student', 
            'preAssessment', 
            'academics', 
            'englishTests', 
            'referees', 
            'documents',
            'completionPercent'
        ));
    }

    public function approve($id)
    {
        $student = Student::findOrFail($id);
        
        $student->enrolment_status = 'approved';
        $student->save();
        
        return back()->with('success', "Student '{$student->first_name}' pre-enrolment approved.");
    }

    public function reject($id)
    {
        $student = Student::findOrFail($id);
        $student->enrolment_status = 'rejected';
        $student->save();
        return redirect()->back()->with('success', 'Pre-Enrolment rejected.');
    }

    public function enrolledStudents(Request $request)
    {
        $search  = $request->get('search', '');
        $sortBy  = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $perPage = (int) $request->get('per_page', 20);
        $perPage = in_array($perPage, [10, 20, 50, 100]) ? $perPage : 20;

        $allowedSorts = ['created_at', 'first_name', 'surname', 'email', 'phone', 'student_id'];
        if (!in_array($sortBy, $allowedSorts)) $sortBy = 'created_at';
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
            
            // If they still have an Applicant ID, upgrade it to a Student ID
            if (str_starts_with($student->student_id, 'APP')) {
                $yearMonth = date('ym');
                $count = \App\Models\Student::where('student_id', 'like', 'ST' . $yearMonth . '%')->count() + 1;
                $serial = str_pad($count, 2, '0', STR_PAD_LEFT);
                $initialFirstName = strtoupper(substr($student->first_name ?? 'X', 0, 1));
                $initialLastName  = strtoupper(substr($student->surname ?? 'X', 0, 1));
                $newStudentId = 'ST' . $yearMonth . $serial . $initialFirstName . $initialLastName;
                $student->student_id = $newStudentId;
            }
            
            $student->enrolment_status = 'enrolled';
            $student->save();
            return redirect()->back()->with('success', 'Student data moved to Enrolled Students successfully. ID: ' . $student->student_id);
        }
        return redirect()->back()->with('error', 'Student must be approved in Pre-Enrolment first.');
    }

    public function revertToPending($id)
    {
        $student = Student::findOrFail($id);
        if ($student->enrolment_status !== 'rejected') {
            return back()->with('error', 'Only rejected pre-enrolments can be reverted.');
        }
        $student->enrolment_status = 'pending';
        $student->save();
        return back()->with('success', 'Pre-Enrolment reverted to pending.');
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

        return back()->with('success', "Student '{$name}' has been successfully deleted.");
    }
}
