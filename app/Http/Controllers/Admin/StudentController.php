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

        if ($status === 'approved') {
            $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])
                ->where('enrolment_status', 'approved')
                ->whereDoesntHave('applications');
        } elseif ($status === 'assigned') {
            $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])
                ->where('enrolment_status', 'approved')
                ->whereHas('applications');
        } else {
            $studentsQuery = Student::with(['campus', 'user', 'preAssessment'])
                ->where('enrolment_status', $status);
        }

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
            'approved' => Student::where('enrolment_status', 'approved')->whereDoesntHave('applications')->count(),
            'assigned' => Student::where('enrolment_status', 'approved')->whereHas('applications')->count(),
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

        $application = \App\Models\StudentApplication::with(['course', 'additionalCosts', 'installments'])
            ->where('student_id', $student->id)
            ->latest()
            ->first();

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
            'invoiceHistory',
            'application'
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

        $studentsQuery = Student::with(['campus', 'user', 'preAssessment', 'applications.course'])
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

    public function manageEnrolmentDetails($studentId)
    {
        $student = Student::findOrFail($studentId);

        $preAssessment = $student->preAssessment;
        if (!$preAssessment || $preAssessment->assessment_status !== 'approved' || $student->enrolment_status === 'pending') {
            return redirect()->route('admin.students.show', $student->id)
                ->with('error', 'Course cannot be assigned while Pre-Enrolment / Pre-Assessment is Pending. Please approve it first.');
        }

        $courses = \App\Models\Course::where('status', 'active')->get();
        $costTypes = \App\Models\DropdownOption::active('additional_cost');
        
        $application = \App\Models\StudentApplication::with(['additionalCosts', 'installments'])
            ->where('student_id', $student->id)
            ->first();

        $coursesJson = $courses->keyBy('id')->map(function($course) {
            return [
                'fee' => $course->fee,
                'currency' => $course->currency ?? 'GBP',
            ];
        })->toJson();

        return view('backend.admin.students.manage_enrolment', compact('student', 'courses', 'costTypes', 'application', 'coursesJson'));
    }

    public function saveEnrolmentDetails(Request $request, $studentId)
    {
        $student = Student::findOrFail($studentId);

        $preAssessment = $student->preAssessment;
        if (!$preAssessment || $preAssessment->assessment_status !== 'approved' || $student->enrolment_status === 'pending') {
            return redirect()->route('admin.students.show', $student->id)
                ->with('error', 'Course cannot be assigned while Pre-Enrolment / Pre-Assessment is Pending. Please approve it first.');
        }
        
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'scholarship_amount' => 'nullable|numeric|min:0',
            'additional_costs' => 'nullable|array',
            'additional_costs.*.cost_name' => 'required|string',
            'additional_costs.*.amount' => 'required|numeric|min:0',
            'installments' => 'required|array|min:1',
            'installments.*.amount' => 'required|numeric|min:0.01',
            'installments.*.due_date' => 'required|date',
            'installments.*.status' => 'required|in:pending,paid,partially_paid',
            'installments.*.paid_amount' => 'nullable|numeric|min:0',
        ]);

        \DB::transaction(function() use ($request, $student) {
            $course = \App\Models\Course::findOrFail($request->course_id);
            $scholarship = floatval($request->scholarship_amount ?? 0);
            $baseFee = floatval($course->fee);
            $netCourseFee = max(0, $baseFee - $scholarship);

            $application = \App\Models\StudentApplication::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'course_id' => $request->course_id,
                    'assigned_agent_id' => $student->agent_id,
                    'stage' => 'accepted',
                    'scholarship_amount' => $scholarship,
                    'net_course_fee' => $netCourseFee,
                    'total_fee' => 0, // Set temporarily
                    'paid_amount' => 0,
                ]
            );

            $application->additionalCosts()->delete();
            $additionalCostsTotal = 0;
            if ($request->has('additional_costs')) {
                foreach ($request->additional_costs as $costData) {
                    $application->additionalCosts()->create([
                        'cost_name' => $costData['cost_name'],
                        'amount' => $costData['amount'],
                    ]);
                    $additionalCostsTotal += $costData['amount'];
                }
            }

            $grandTotal = $netCourseFee + $additionalCostsTotal;

            $application->installments()->delete();
            $totalApplicationPaid = 0;
            foreach ($request->installments as $index => $instData) {
                $status = $instData['status'] ?? 'pending';
                $paid = 0;
                if ($status === 'paid') {
                    $paid = $instData['amount'];
                } elseif ($status === 'partially_paid') {
                    $paid = min($instData['paid_amount'] ?? 0, $instData['amount']);
                }

                $application->installments()->create([
                    'installment_number' => $index + 1,
                    'amount' => $instData['amount'],
                    'due_date' => $instData['due_date'],
                    'status' => $status,
                    'paid_amount' => $paid,
                ]);

                $totalApplicationPaid += $paid;
            }

            $application->update([
                'scholarship_amount' => $scholarship,
                'net_course_fee' => $netCourseFee,
                'total_fee' => $grandTotal,
                'paid_amount' => $totalApplicationPaid,
                'stage' => ($totalApplicationPaid >= $grandTotal) ? 'payment_made' : 'accepted'
            ]);
        });

        if ($student->enrolment_status === 'enrolled') {
            return redirect()->route('admin.students.enrolled')
                ->with('success', 'Enrolment & fee details saved successfully.');
        }

        return redirect()->route('admin.students.index', ['status' => 'assigned'])
            ->with('success', 'Enrolment & fee details saved successfully.');
    }

    public function recordInstallmentPayment(Request $request, $installmentId)
    {
        $installment = \App\Models\StudentApplicationInstallment::findOrFail($installmentId);
        $application = $installment->application;
        
        $maxAllowed = number_format($installment->amount - $installment->paid_amount, 2, '.', '');

        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01|max:' . $maxAllowed,
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('payment_attachments', 'public');
        }

        $installment->pending_paid_amount = $request->amount_paid;
        $installment->payment_method = $request->payment_method ?? 'Cash';
        $installment->transaction_id = $request->transaction_id ?? null;
        if ($attachmentPath) {
            $installment->attachment = $attachmentPath;
        }
        $installment->approval_status = 'pending_approval';
        $installment->status = 'pending_approval';
        $installment->save();

        return back()->with('success', 'Payment request of ' . number_format($request->amount_paid, 2) . ' ' . ($application->course->currency ?? 'GBP') . ' submitted and is pending admin approval.');
    }

    public function approveInstallmentPayment($installmentId)
    {
        $installment = \App\Models\StudentApplicationInstallment::findOrFail($installmentId);
        $application = $installment->application;

        \DB::transaction(function() use ($installment, $application) {
            $amountToAdd = $installment->pending_paid_amount ?? ($installment->amount - $installment->paid_amount);
            $installment->paid_amount += $amountToAdd;
            $installment->pending_paid_amount = 0;
            $installment->paid_at = now();
            $installment->approval_status = 'approved';

            if ($installment->paid_amount >= $installment->amount) {
                $installment->status = 'paid';
            } else {
                $installment->status = 'partially_paid';
            }
            $installment->save();

            $totalPaidInstallments = $application->installments()->whereIn('status', ['paid', 'partially_paid'])->sum('paid_amount');
            $totalPaidCosts = $application->additionalCosts()->where('status', 'paid')->sum('paid_amount');
            $application->paid_amount = $totalPaidInstallments + $totalPaidCosts;

            if ($application->paid_amount >= $application->total_fee) {
                $application->stage = 'payment_made';
            }
            $application->save();
        });

        return back()->with('success', 'Installment payment approved successfully.');
    }

    public function rejectInstallmentPayment($installmentId)
    {
        $installment = \App\Models\StudentApplicationInstallment::findOrFail($installmentId);
        $installment->pending_paid_amount = 0;
        $installment->approval_status = 'rejected';
        if ($installment->paid_amount > 0) {
            $installment->status = 'partially_paid';
        } else {
            $installment->status = 'pending';
        }
        $installment->save();

        return back()->with('info', 'Installment payment request rejected.');
    }

    public function recordAdditionalCostPayment(Request $request, $costId)
    {
        $cost = \App\Models\StudentApplicationAdditionalCost::findOrFail($costId);
        $application = $cost->application;

        $request->validate([
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('payment_attachments', 'public');
        }

        $cost->payment_method = $request->payment_method ?? 'Cash/Direct';
        $cost->transaction_id = $request->transaction_id ?? null;
        if ($attachmentPath) {
            $cost->attachment = $attachmentPath;
        }
        $cost->approval_status = 'pending_approval';
        $cost->status = 'pending_approval';
        $cost->save();

        return back()->with('success', 'Payment submission for "' . $cost->cost_name . '" received and is pending admin approval.');
    }

    public function approveAdditionalCostPayment($costId)
    {
        $cost = \App\Models\StudentApplicationAdditionalCost::findOrFail($costId);
        $application = $cost->application;

        \DB::transaction(function() use ($cost, $application) {
            $cost->status = 'paid';
            $cost->paid_amount = $cost->amount;
            $cost->paid_at = now();
            $cost->approval_status = 'approved';
            $cost->save();

            $totalPaidInstallments = $application->installments()->whereIn('status', ['paid', 'partially_paid'])->sum('paid_amount');
            $totalPaidCosts = $application->additionalCosts()->where('status', 'paid')->sum('paid_amount');
            $application->paid_amount = $totalPaidInstallments + $totalPaidCosts;

            if ($application->paid_amount >= $application->total_fee) {
                $application->stage = 'payment_made';
            }
            $application->save();
        });

        return back()->with('success', 'Additional cost payment approved successfully.');
    }

    public function rejectAdditionalCostPayment($costId)
    {
        $cost = \App\Models\StudentApplicationAdditionalCost::findOrFail($costId);
        $cost->approval_status = 'rejected';
        $cost->status = 'pending';
        $cost->save();

        return back()->with('info', 'Additional cost payment request rejected.');
    }
}
