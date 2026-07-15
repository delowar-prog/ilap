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
        $status = $request->get('status', 'pending');

        $studentsQuery = Student::with(['campus', 'user', 'preAssessment']);

        if ($status === 'pending') {
            $studentsQuery->where('enrolment_status', 'pending');
        } elseif ($status === 'approved') {
            $studentsQuery->where('enrolment_status', 'approved');
        } elseif ($status === 'rejected') {
            $studentsQuery->where('enrolment_status', 'rejected');
        }

        $students = $studentsQuery->latest()->paginate(20);

        $counts = [
            'pending'  => Student::where('enrolment_status', 'pending')->count(),
            'approved' => Student::where('enrolment_status', 'approved')->count(),
            'rejected' => Student::where('enrolment_status', 'rejected')->count(),
        ];

        return view('backend.admin.students.index', compact('students', 'status', 'counts'));
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
        $student->update(['enrolment_status' => 'approved']);
        return back()->with('success', "Student '{$student->first_name}' pre-enrolment approved.");
    }

    public function reject($id)
    {
        $student = Student::findOrFail($id);
        $student->enrolment_status = 'rejected';
        $student->save();
        return redirect()->back()->with('success', 'Pre-Enrolment rejected.');
    }

    public function enrolledStudents()
    {
        $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])->where('enrolment_status', 'enrolled');
        $students = $studentsQuery->latest()->paginate(20);
        return view('backend.admin.students.enrolled', compact('students'));
    }

    public function sendToStudent($id)
    {
        $student = Student::findOrFail($id);
        if ($student->enrolment_status === 'approved') {
            $student->enrolment_status = 'enrolled';
            $student->save();
            return redirect()->back()->with('success', 'Student data moved to Enrolled Students successfully.');
        }
        return redirect()->back()->with('error', 'Student must be approved in Pre-Enrolment first.');
    }
}
