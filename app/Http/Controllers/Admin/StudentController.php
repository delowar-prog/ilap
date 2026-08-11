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
            'terminated' => Student::where('enrolment_status', 'terminated')->count(),
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

    public function terminateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        \DB::transaction(function() use ($request, $student) {
            $student->enrolment_status = 'terminated';
            $student->terminated_at = now();
            $student->termination_reason = $request->termination_reason ?? 'Student discontinued course after enrolment.';
            $student->save();

            // Waive all unpaid installments for this student's applications
            foreach ($student->applications as $application) {
                $application->installments()->where('status', '!=', 'paid')->update([
                    'status' => 'waived',
                    'approval_status' => 'none',
                ]);
                $application->additionalCosts()->where('status', '!=', 'paid')->update([
                    'status' => 'waived',
                    'approval_status' => 'none',
                ]);

                // Recalculate paid_amount
                $totalPaidInstallments = $application->installments()->where('status', 'paid')->sum('paid_amount');
                $totalPaidCosts = $application->additionalCosts()->where('status', 'paid')->sum('paid_amount');
                $application->paid_amount = $totalPaidInstallments + $totalPaidCosts;
                $application->save();
            }
        });

        $msg = 'Student status marked as Terminated. Remaining unpaid balance has been waived/adjusted.';
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }

        return back()->with('success', $msg);
    }

    public function reinstallStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        \DB::transaction(function() use ($student) {
            $student->enrolment_status = 'enrolled';
            $student->terminated_at = null;
            $student->termination_reason = null;
            $student->save();

            // Revert waived installments back to pending
            foreach ($student->applications as $application) {
                $application->installments()->where('status', 'waived')->update([
                    'status' => 'pending',
                ]);
                $application->additionalCosts()->where('status', 'waived')->update([
                    'status' => 'pending',
                ]);
            }
        });

        $msg = 'Student re-enrolled successfully. Waived installments have been restored.';
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => $msg]);
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
            'additional_costs.*.note' => 'nullable|string|max:500',
            'installments' => 'required|array|min:1',
            'installments.*.amount' => 'required|numeric|min:0.01',
            'installments.*.due_date' => 'required|date',
            'installments.*.note' => 'nullable|string|max:500',
            'installments.*.status' => 'nullable|string',
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
                        'note' => $costData['note'] ?? null,
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
                    'note' => $instData['note'] ?? null,
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
            'bank_fee' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('payment_attachments', 'public');
        }

        $installment->pending_paid_amount = $request->amount_paid;
        $installment->bank_fee = $request->bank_fee ?? 0;
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
            'bank_fee' => 'nullable|numeric|min:0',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('payment_attachments', 'public');
        }

        $cost->bank_fee = $request->bank_fee ?? 0;
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

    public function refundInstallment(Request $request, $installmentId)
    {
        $installment = \App\Models\StudentApplicationInstallment::findOrFail($installmentId);
        $application = $installment->application;

        $maxRefundable = floatval($installment->paid_amount);
        if ($maxRefundable <= 0) {
            return back()->with('error', 'This installment does not have any paid amount eligible for refund.');
        }

        $request->validate([
            'refund_amount' => 'required|numeric|min:0.00|max:' . $maxRefundable,
            'deduction_percentage' => 'nullable|numeric|min:0|max:100',
            'deduction_amount' => 'nullable|numeric|min:0|max:' . $maxRefundable,
            'reason_note' => 'required|string|max:1000',
        ]);

        $refundAmount = floatval($request->refund_amount);
        $deductionAmount = floatval($request->deduction_amount ?? 0);
        $deductionPct = $request->has('deduction_percentage') && $request->deduction_percentage !== null ? floatval($request->deduction_percentage) : null;

        if (($refundAmount + $deductionAmount) > ($maxRefundable + 0.01)) {
            return back()->with('error', 'Refund amount plus deduction cannot exceed total paid amount of ' . format_currency($maxRefundable, $application->course->currency ?? 'GBP') . '.');
        }

        \DB::transaction(function() use ($request, $installment, $application, $maxRefundable, $refundAmount, $deductionAmount, $deductionPct) {
            \App\Models\StudentApplicationRefund::create([
                'application_id' => $application->id,
                'refund_type' => 'installment',
                'item_id' => $installment->id,
                'original_paid_amount' => $maxRefundable,
                'deduction_percentage' => $deductionPct,
                'deduction_amount' => $deductionAmount,
                'refund_amount' => $refundAmount,
                'reason_note' => $request->reason_note,
                'processed_by' => auth()->id(),
                'refunded_at' => now(),
            ]);

            $newPaidAmount = max(0, $installment->paid_amount - $refundAmount - $deductionAmount);
            $installment->paid_amount = $newPaidAmount;
            $installment->refunded_amount = ($installment->refunded_amount ?? 0) + $refundAmount;
            $installment->deducted_amount = ($installment->deducted_amount ?? 0) + $deductionAmount;

            if ($newPaidAmount == 0) {
                $installment->status = 'refunded';
            } else {
                $installment->status = 'partially_refunded';
            }
            $installment->save();

            $totalPaidInstallments = $application->installments()->sum('paid_amount');
            $totalPaidCosts = $application->additionalCosts()->sum('paid_amount');
            $application->paid_amount = $totalPaidInstallments + $totalPaidCosts;

            if ($application->paid_amount < $application->total_fee) {
                $application->stage = 'accepted';
            }
            $application->save();
        });

        return back()->with('success', 'Refund of ' . format_currency($refundAmount, $application->course->currency ?? 'GBP') . ' processed successfully.');
    }

    public function refundAdditionalCost(Request $request, $costId)
    {
        $cost = \App\Models\StudentApplicationAdditionalCost::findOrFail($costId);
        $application = $cost->application;

        $maxRefundable = floatval($cost->paid_amount > 0 ? $cost->paid_amount : ($cost->status === 'paid' ? $cost->amount : 0));
        if ($maxRefundable <= 0) {
            return back()->with('error', 'This item does not have any paid amount eligible for refund.');
        }

        $request->validate([
            'refund_amount' => 'required|numeric|min:0.00|max:' . $maxRefundable,
            'deduction_percentage' => 'nullable|numeric|min:0|max:100',
            'deduction_amount' => 'nullable|numeric|min:0|max:' . $maxRefundable,
            'reason_note' => 'required|string|max:1000',
        ]);

        $refundAmount = floatval($request->refund_amount);
        $deductionAmount = floatval($request->deduction_amount ?? 0);
        $deductionPct = $request->has('deduction_percentage') && $request->deduction_percentage !== null ? floatval($request->deduction_percentage) : null;

        if (($refundAmount + $deductionAmount) > ($maxRefundable + 0.01)) {
            return back()->with('error', 'Refund amount plus deduction cannot exceed total paid amount of ' . format_currency($maxRefundable, $application->course->currency ?? 'GBP') . '.');
        }

        \DB::transaction(function() use ($request, $cost, $application, $maxRefundable, $refundAmount, $deductionAmount, $deductionPct) {
            \App\Models\StudentApplicationRefund::create([
                'application_id' => $application->id,
                'refund_type' => 'additional_cost',
                'item_id' => $cost->id,
                'original_paid_amount' => $maxRefundable,
                'deduction_percentage' => $deductionPct,
                'deduction_amount' => $deductionAmount,
                'refund_amount' => $refundAmount,
                'reason_note' => $request->reason_note,
                'processed_by' => auth()->id(),
                'refunded_at' => now(),
            ]);

            $newPaidAmount = max(0, $maxRefundable - $refundAmount - $deductionAmount);
            $cost->paid_amount = $newPaidAmount;
            $cost->refunded_amount = ($cost->refunded_amount ?? 0) + $refundAmount;
            $cost->deducted_amount = ($cost->deducted_amount ?? 0) + $deductionAmount;

            if ($newPaidAmount == 0) {
                $cost->status = 'refunded';
            } else {
                $cost->status = 'partially_refunded';
            }
            $cost->save();

            $totalPaidInstallments = $application->installments()->sum('paid_amount');
            $totalPaidCosts = $application->additionalCosts()->sum('paid_amount');
            $application->paid_amount = $totalPaidInstallments + $totalPaidCosts;

            if ($application->paid_amount < $application->total_fee) {
                $application->stage = 'accepted';
            }
            $application->save();
        });

        return back()->with('success', 'Refund of ' . format_currency($refundAmount, $application->course->currency ?? 'GBP') . ' for cost "' . $cost->cost_name . '" processed successfully.');
    }

    public function discountInstallment(Request $request, $installmentId)
    {
        $installment = \App\Models\StudentApplicationInstallment::findOrFail($installmentId);
        $application = $installment->application;

        $paidAmount = floatval($installment->paid_amount ?? 0);
        $currentAmount = floatval($installment->amount ?? 0);
        $remainingDue = max(0, $currentAmount - $paidAmount);

        if ($remainingDue <= 0) {
            return back()->with('error', 'This installment has no remaining due balance eligible for discount.');
        }

        $request->validate([
            'discount_mode' => 'required|in:amount,percentage,full_waive',
            'discount_value' => 'nullable|numeric|min:0',
            'reason_note' => 'required|string|max:1000',
        ]);

        $mode = $request->discount_mode;
        $val = floatval($request->discount_value ?? 0);
        $discountAmount = 0;

        if ($mode === 'full_waive') {
            $discountAmount = $remainingDue;
        } elseif ($mode === 'percentage') {
            if ($val <= 0 || $val > 100) {
                return back()->with('error', 'Discount percentage must be between 0 and 100.');
            }
            $discountAmount = round(($remainingDue * $val) / 100, 2);
        } else {
            if ($val <= 0) {
                return back()->with('error', 'Discount amount must be greater than zero.');
            }
            $discountAmount = round($val, 2);
        }

        if ($discountAmount > $remainingDue + 0.01) {
            return back()->with('error', 'Discount amount cannot exceed the remaining due of ' . format_currency($remainingDue, $application->course->currency ?? 'GBP') . '.');
        }

        $discountAmount = min($remainingDue, $discountAmount);

        \DB::transaction(function() use ($request, $installment, $application, $remainingDue, $discountAmount, $paidAmount) {
            $currency = $application->course->currency ?? 'GBP';
            $formattedDiscount = format_currency($discountAmount, $currency);
            $reasonNote = trim($request->reason_note);
            $noteText = "Discount applied: {$formattedDiscount} ({$reasonNote})";

            $newAmount = max($paidAmount, $installment->amount - $discountAmount);
            $installment->amount = $newAmount;

            if ($installment->note) {
                $installment->note .= " | " . $noteText;
            } else {
                $installment->note = $noteText;
            }

            if ($discountAmount >= $remainingDue) {
                if ($paidAmount > 0) {
                    $installment->status = 'paid';
                } else {
                    $installment->status = 'waived';
                }
            } else {
                if ($paidAmount > 0) {
                    $installment->status = 'partially_paid';
                } else {
                    $installment->status = 'pending';
                }
            }
            $installment->save();

            // Recalculate Application Total Fees
            $netCourseFee = $application->installments()->sum('amount');
            $additionalCostsFee = $application->additionalCosts()->sum('amount');
            $application->net_course_fee = $netCourseFee;
            $application->total_fee = $netCourseFee + $additionalCostsFee;
            $application->save();
        });

        return back()->with('success', 'Discount of ' . format_currency($discountAmount, $application->course->currency ?? 'GBP') . ' applied successfully.');
    }

    public function discountAdditionalCost(Request $request, $costId)
    {
        $cost = \App\Models\StudentApplicationAdditionalCost::findOrFail($costId);
        $application = $cost->application;

        $paidAmount = floatval($cost->paid_amount ?? 0);
        $currentAmount = floatval($cost->amount ?? 0);
        $remainingDue = max(0, $currentAmount - $paidAmount);

        if ($remainingDue <= 0) {
            return back()->with('error', 'This additional cost item has no remaining due balance eligible for discount.');
        }

        $request->validate([
            'discount_mode' => 'required|in:amount,percentage,full_waive',
            'discount_value' => 'nullable|numeric|min:0',
            'reason_note' => 'required|string|max:1000',
        ]);

        $mode = $request->discount_mode;
        $val = floatval($request->discount_value ?? 0);
        $discountAmount = 0;

        if ($mode === 'full_waive') {
            $discountAmount = $remainingDue;
        } elseif ($mode === 'percentage') {
            if ($val <= 0 || $val > 100) {
                return back()->with('error', 'Discount percentage must be between 0 and 100.');
            }
            $discountAmount = round(($remainingDue * $val) / 100, 2);
        } else {
            if ($val <= 0) {
                return back()->with('error', 'Discount amount must be greater than zero.');
            }
            $discountAmount = round($val, 2);
        }

        if ($discountAmount > $remainingDue + 0.01) {
            return back()->with('error', 'Discount amount cannot exceed the remaining due of ' . format_currency($remainingDue, $application->course->currency ?? 'GBP') . '.');
        }

        $discountAmount = min($remainingDue, $discountAmount);

        \DB::transaction(function() use ($request, $cost, $application, $remainingDue, $discountAmount, $paidAmount) {
            $currency = $application->course->currency ?? 'GBP';
            $formattedDiscount = format_currency($discountAmount, $currency);
            $reasonNote = trim($request->reason_note);
            $noteText = "Discount applied: {$formattedDiscount} ({$reasonNote})";

            $newAmount = max($paidAmount, $cost->amount - $discountAmount);
            $cost->amount = $newAmount;

            if ($cost->note) {
                $cost->note .= " | " . $noteText;
            } else {
                $cost->note = $noteText;
            }

            if ($discountAmount >= $remainingDue) {
                if ($paidAmount > 0) {
                    $cost->status = 'paid';
                } else {
                    $cost->status = 'waived';
                }
            }
            $cost->save();

            // Recalculate Application Total Fees
            $netCourseFee = $application->installments()->sum('amount');
            $additionalCostsFee = $application->additionalCosts()->sum('amount');
            $application->net_course_fee = $netCourseFee;
            $application->total_fee = $netCourseFee + $additionalCostsFee;
            $application->save();
        });

        return back()->with('success', 'Discount of ' . format_currency($discountAmount, $application->course->currency ?? 'GBP') . ' for cost "' . $cost->cost_name . '" applied successfully.');
    }
}
