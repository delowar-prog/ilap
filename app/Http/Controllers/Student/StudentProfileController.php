<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAcademic;
use App\Models\StudentEnglishTest;
use App\Models\StudentReferee;
use App\Models\StudentDocument;
use App\Models\StudentPreAssessment;
use App\Models\Institute;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            $campus = \App\Models\Campus::first();
            $campusId = $campus ? $campus->id : 1;
            $campusCodeStr = $campus ? $campus->campus_code : 'CMP1';
            
            $firstName = $user->user_first_name ?? $user->name ?? 'X';
            $surname = $user->user_last_name ?? 'X';
            
            $yearMonth = date('ym'); // e.g. 2607 for July 2026
            $count = \App\Models\Student::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;
            $serial = str_pad($count, 2, '0', STR_PAD_LEFT);
            $initialFirstName = strtoupper(substr($firstName, 0, 1));
            $initialLastName  = strtoupper(substr($surname, 0, 1));
            $studentId = 'APP' . $yearMonth . $serial . $initialFirstName . $initialLastName;

            // Fallback: If user somehow doesn't have a student profile yet, create one
            $student = Student::create([
                'campus_id' => $campusId,
                'user_id' => $user->id,
                'first_name' => $firstName,
                'surname' => $surname,
                'email' => $user->email,
                'student_id' => $studentId,
            ]);
        }
        
        $preAssessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);
        $academics = StudentAcademic::where('student_id', $student->id)->get();
        $englishTests = StudentEnglishTest::where('student_id', $student->id)->get();
        $referees = StudentReferee::where('student_id', $student->id)->get();
        $documents = StudentDocument::where('student_id', $student->id)->get();
        // Calculate Completion Percentage
        $completionPercent = 10; // Base percentage
        
        // Personal Info Check
        if ($student->phone && $student->current_address && $student->dob && $student->nationality) {
            $completionPercent += 30;
        } elseif ($student->phone || $student->current_address) {
            $completionPercent += 15;
        }

        // Academic Check
        if ($academics->count() > 0) {
            $completionPercent += 20;
        }

        // English Test Check
        if ($englishTests->count() > 0 || $student->native_language) {
            $completionPercent += 20;
        }

        // Referees Check
        if ($referees->count() > 0) {
            $completionPercent += 10;
        }

        // Documents Check
        if ($documents->count() > 0) {
            $completionPercent += 10;
        }

        $completionPercent = min($completionPercent, 100);
        
        return view('backend.student.student_dashbord', compact(
            'student', 
            'preAssessment', 
            'academics', 
            'englishTests', 
            'referees', 
            'documents',
            'completionPercent'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('student.dashboard')->withErrors(['Profile not found.']);
        }
        
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

        return view('backend.student.student_view_profile', compact(
            'student', 
            'preAssessment', 
            'academics', 
            'englishTests', 
            'referees', 
            'documents',
            'completionPercent'
        ));
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->route('student.dashboard')->withErrors(['Profile not found.']);
        }
        
        $preAssessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);
        $academics = StudentAcademic::where('student_id', $student->id)->get();
        $englishTests = StudentEnglishTest::where('student_id', $student->id)->get();
        $referees = StudentReferee::where('student_id', $student->id)->get();
        $institutes = Institute::where('status', 'active')->orderBy('name')->get();
        $courses = Course::active()->orderBy('name')->get();
        
        // Documents list with filter, latest first and pagination
        $docQuery = StudentDocument::where('student_id', $student->id)->where('uploaded_by', 'student');
        if ($request->has('doc_search') && !empty($request->doc_search)) {
            $search = $request->doc_search;
            $docQuery->where(function($q) use ($search) {
                $q->where('document_type', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }
        $documents = $docQuery->latest()->paginate(5)->withQueryString();

        // Admin uploaded documents list with filter
        $adminDocQuery = StudentDocument::where('student_id', $student->id)->where('uploaded_by', 'admin');
        if ($request->has('admin_doc_search') && !empty($request->admin_doc_search)) {
            $search = $request->admin_doc_search;
            $adminDocQuery->where(function($q) use ($search) {
                $q->where('document_type', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }
        $adminDocuments = $adminDocQuery->latest()->paginate(5, ['*'], 'admin_page')->withQueryString();

        // Calculate Completion Percentage
        $completionPercent = 10;
        if ($student->phone && $student->current_address && $student->dob && $student->nationality) { $completionPercent += 30; }
        elseif ($student->phone || $student->current_address) { $completionPercent += 15; }
        if ($academics->count() > 0) { $completionPercent += 20; }
        if ($englishTests->count() > 0 || $student->native_language) { $completionPercent += 20; }
        if ($referees->count() > 0) { $completionPercent += 10; }
        if (StudentDocument::where('student_id', $student->id)->where('uploaded_by', 'student')->exists()) { $completionPercent += 10; }
        $completionPercent = min($completionPercent, 100);

        $mandatoryDocs = [];
        if ($student->preAssessment && $student->preAssessment->mandatory_documents) {
            $mandatoryDocs = $student->preAssessment->mandatory_documents;
        }
        
        $uploadedDocTypes = \App\Models\StudentDocument::where('student_id', $student->id)
            ->where('uploaded_by', 'student')
            ->pluck('document_type')
            ->toArray();

        // Fetch dynamic dropdowns for profile edit forms
        $studyMethods           = \App\Models\DropdownOption::active('study_method');
        $levelOfStudyOptions    = \App\Models\DropdownOption::active('level_of_study');
        $financialSourceOptions = \App\Models\DropdownOption::active('financial_source');
        $qualificationOptions   = \App\Models\DropdownOption::active('highest_qualification');
        $countriesList          = \App\Models\Country::where('status', 'active')->orderBy('name')->pluck('name')->toArray();
        $citiesList             = \App\Models\City::where('status', 'active')->orderBy('name')->pluck('name')->toArray();

        return view('backend.student.student_profile', compact(
            'student', 
            'preAssessment', 
            'academics', 
            'englishTests', 
            'referees', 
            'documents',
            'adminDocuments',
            'institutes',
            'courses',
            'completionPercent',
            'mandatoryDocs',
            'uploadedDocTypes',
            'studyMethods',
            'levelOfStudyOptions',
            'financialSourceOptions',
            'qualificationOptions',
            'countriesList',
            'citiesList'
        ));
    }

    public function updatePersonal(Request $request)
    {
        $student = Auth::user()->student;

        $studentFields = [
            'title','first_name','middle_name','surname','dob','gender','nationality',
            'country_of_birth','native_language','email','phone','skype_id',
            'name_in_passport','passport_number','passport_issue_location',
            'passport_issue_date','passport_expiry_date',
            'permanent_address','permanent_city','permanent_postcode','permanent_country',
            'current_address','current_city','current_postcode','current_country',
            'emergency_contact_name','emergency_contact_mobile','emergency_contact_email',
            'emergency_contact_relationship','applied_leave_to_remain_uk','need_visa_for_uk',
            'refused_visa_or_deported','taken_tb_test','bank_balance_info',
        ];

        $data = $request->only($studentFields);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_pictures', $filename, 'public');
            $data['profile_picture'] = 'storage/profile_pictures/' . $filename;
        }

        $student->update($data);
        return response()->json(['success' => true, 'message' => 'Details saved successfully!']);
    }

    public function updateAcademic(Request $request)
    {
        $student = Auth::user()->student;
        
        if ($request->has('academics')) {
            // Basic sync mechanism: delete old and recreate, or update if ID is present
            // For simplicity in a multi-step form, if they submit the full array:
            foreach ($request->academics as $academic) {
                if (!empty($academic['education_level']) && !empty($academic['institution_name'])) {
                    // Fix dates that come from month inputs (YYYY-MM)
                    $dateFields = ['start_date', 'end_date', 'award_date'];
                    foreach($dateFields as $df) {
                        if (!empty($academic[$df]) && strlen($academic[$df]) === 7) {
                            $academic[$df] .= '-01';
                        }
                    }

                    if (!empty($academic['id'])) {
                        StudentAcademic::where('id', $academic['id'])->where('student_id', $student->id)->update($academic);
                    } else {
                        $academic['student_id'] = $student->id;
                        StudentAcademic::create($academic);
                    }
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Academic history updated.']);
    }
    
    public function updateEnglish(Request $request)
    {
        $student = Auth::user()->student;
        
        // Save travel history to the student table
        $travelFields = [
            'applied_leave_to_remain_uk', 'need_visa_for_uk', 
            'refused_visa_or_deported', 'taken_tb_test'
        ];
        $student->update($request->only($travelFields));
        
        if ($request->has('english_tests')) {
            foreach ($request->english_tests as $test) {
                if (!empty($test['test_name'])) {
                    if (!empty($test['id'])) {
                        StudentEnglishTest::where('id', $test['id'])->where('student_id', $student->id)->update($test);
                    } else {
                        $test['student_id'] = $student->id;
                        StudentEnglishTest::create($test);
                    }
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Travel & English info updated.']);
    }

    public function updatePreferences(Request $request)
    {
        $student = Auth::user()->student;
        $preAssessment = StudentPreAssessment::firstOrCreate(['student_id' => $student->id]);
        
        // Try to resolve institute_id from institute_name
        if ($request->has('institute_name')) {
            $inst = Institute::where('name', $request->institute_name)->first();
            $student->update(['institute_id' => $inst ? $inst->id : null]);
        } elseif ($request->has('institute_id')) {
            $student->update(['institute_id' => $request->institute_id]);
        }

        if ($request->has('bank_balance_info')) {
            $student->update(['bank_balance_info' => $request->bank_balance_info]);
        }

        $preAssessment->update($request->except(['_token', 'institute_id', 'bank_balance_info']));
        
        return response()->json(['success' => true, 'message' => 'Preferences updated successfully.']);
    }
    
    public function updateReferees(Request $request)
    {
        $student = Auth::user()->student;

        // Save bank_balance_info to student table if present
        if ($request->has('bank_balance_info')) {
            $student->update(['bank_balance_info' => $request->bank_balance_info]);
        }

        if ($request->has('referees')) {
            foreach ($request->referees as $referee) {
                if (!empty($referee['full_name'])) {
                    $data = array_filter($referee, fn($v) => $v !== null && $v !== '');
                    if (!empty($data['id'])) {
                        $id = $data['id'];
                        unset($data['id']);
                        StudentReferee::where('id', $id)->where('student_id', $student->id)->update($data);
                    } else {
                        unset($data['id']);
                        $data['student_id'] = $student->id;
                        StudentReferee::create($data);
                    }
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Referee details saved!']);
    }

    public function uploadDocument(Request $request)
    {
        $student = Auth::user()->student;

        if ($request->has('documents') && is_array($request->documents)) {
            $uploadedCount = 0;
            foreach ($request->documents as $doc) {
                if (isset($doc['file']) && $doc['file']->isValid()) {
                    $path = $doc['file']->store('student_documents/' . $student->id, 'public');
                    \App\Models\StudentDocument::create([
                        'student_id' => $student->id,
                        'document_type' => $doc['type'] ?? 'Other',
                        'title' => $doc['title'] ?? '',
                        'file_path' => $path,
                        'uploaded_by' => 'student'
                    ]);
                    $uploadedCount++;
                }
            }
            
            if ($uploadedCount > 0) {
                return response()->json(['success' => true, 'message' => "$uploadedCount document(s) uploaded successfully."]);
            }
        }

        return response()->json(['success' => false, 'message' => 'No valid files provided or upload failed.'], 400);
    }
}
