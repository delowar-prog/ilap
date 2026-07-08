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
    public function index()
    {
        $students = Student::with(['campus', 'user', 'preAssessment'])->get();
        return view('backend.admin.students.index', compact('students'));
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
}
