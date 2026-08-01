<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\InvoiceTemplate;
use App\Models\GeneratedInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\TemplateProcessor;

class StudentInvoiceController extends Controller
{
    /**
     * Display a global archive list of all generated invoices across all students.
     */
    public function globalHistory(Request $request)
    {
        $query = GeneratedInvoice::with(['student', 'generator', 'template']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_title', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('surname', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('student_id', 'like', "%{$search}%");
                  });
            });
        }

        $invoices = $query->latest()->paginate(15);

        return view('backend.invoice_templates.history', compact('invoices'));
    }

    public $activeSignatures = [];

    /**
     * Helper to replace placeholders with real student & financial data.
     */
    private function parsePlaceholders(string $content, Student $student, bool $resetSignatures = false, ?int $installmentId = null, array $installmentIds = [], array $additionalCostIds = [], array $feeSummaryItems = []): string
    {
        if ($resetSignatures) {
            // Reset active signatures list for this parsing session
            $this->activeSignatures = [];
        }

        $fullName = trim(($student->first_name ?? '') . ' ' . ($student->surname ?? $student->last_name ?? ''));
        if (empty($fullName)) {
            $fullName = $student->name ?? 'Student';
        }

        $currentUser = auth()->user();
        $issuerName  = $currentUser ? $currentUser->name : 'Authorized Signatory';
        $issuerDesig = $currentUser?->roles?->first()?->name ?? 'Admin';

        // Fetch student's course application and financials
        $application = \App\Models\StudentApplication::with(['course', 'additionalCosts', 'installments'])
            ->where('student_id', $student->id)
            ->latest()
            ->first();

        $courseName = $application?->course?->name ?? $student->course?->name ?? 'N/A';
        $courseCode = $application?->course?->course_code ?? 'N/A';
        $currency   = $application?->course?->currency ?? 'GBP';
        $baseFee    = (float) ($application?->course?->fee ?? 0);

        $additionalCostsList = $application?->additionalCosts ?? collect();
        $addCostsTotal = $additionalCostsList->sum('amount');
        $grandTotal    = (float) ($application?->total_fee ?? ($baseFee + $addCostsTotal));
        $paidAmountTotal = (float) ($application?->paid_amount ?? 0);
        $dueAmountTotal  = max(0, $grandTotal - $paidAmountTotal);

        // Format additional costs summary text
        $addCostsSummary = [];
        foreach ($additionalCostsList as $ac) {
            $addCostsSummary[] = e($ac->cost_name) . ': ' . $currency . ' ' . number_format($ac->amount, 2);
        }
        $addCostsText = !empty($addCostsSummary) ? implode('<br>', $addCostsSummary) : 'None';

        // Installment specific data
        $selectedInstallment = null;
        if ($installmentId) {
            $selectedInstallment = \App\Models\StudentApplicationInstallment::find($installmentId);
        } elseif (!empty($installmentIds)) {
            $selectedInstallment = \App\Models\StudentApplicationInstallment::find(reset($installmentIds));
        } elseif ($application && $application->installments->count() > 0) {
            // Default to 1st installment if available
            $selectedInstallment = $application->installments->sortBy('installment_number')->first();
        }

        $instNumberText  = '1st Installment';
        $instAmountText  = $currency . ' ' . number_format(0, 2);
        $instDueDateText = 'N/A';
        $instStatusText  = 'Pending';
        $instPaidText    = $currency . ' ' . number_format(0, 2);
        $instBalanceText = $currency . ' ' . number_format(0, 2);

        if ($selectedInstallment) {
            $instNumberText  = ($selectedInstallment->installment_number == 1) ? '1st Installment' : ('Installment #' . $selectedInstallment->installment_number);
            $instAmountText  = $currency . ' ' . number_format($selectedInstallment->amount, 2);
            $instDueDateText = $selectedInstallment->due_date ? date('d M, Y', strtotime($selectedInstallment->due_date)) : 'N/A';
            $instStatusText  = ucfirst(str_replace('_', ' ', $selectedInstallment->status));
            $instPaidText    = $currency . ' ' . number_format($selectedInstallment->paid_amount, 2);
            $instBal         = max(0, $selectedInstallment->amount - $selectedInstallment->paid_amount);
            $instBalanceText = $currency . ' ' . number_format($instBal, 2);
        }

        // Receipt reference
        $receiptNo = 'REC-' . date('Ymd') . '-' . str_pad($student->id, 5, '0', STR_PAD_LEFT);

        // ---- Selected Items Table (for itemized invoice) ----
        $installmentIntIds    = array_map('intval', array_filter((array)$installmentIds));
        $additionalCostIntIds = array_map('intval', array_filter((array)$additionalCostIds));

        $selectedInstallments    = collect();
        $selectedAdditionalCosts = collect();

        if (!empty($installmentIntIds) && $application) {
            $selectedInstallments = $application->installments
                ->whereIn('id', $installmentIntIds)
                ->sortBy('installment_number');
        }

        if (!empty($additionalCostIntIds) && $application) {
            $selectedAdditionalCosts = $application->additionalCosts
                ->whereIn('id', $additionalCostIntIds);
        }

        $selectedItemsTotal = 0.0;
        $selectedItemsPaid  = 0.0;

        $selectedItemsTableHtml  = '<table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; font-size: 13px;" border="1" cellpadding="8">';
        $selectedItemsTableHtml .= '<tr style="background-color: #003366; color: #ffffff;">';
        $selectedItemsTableHtml .= '<th style="text-align: left;">#</th>';
        $selectedItemsTableHtml .= '<th style="text-align: left;">Description</th>';
        $selectedItemsTableHtml .= '<th style="text-align: left;">Category</th>';
        $selectedItemsTableHtml .= '<th style="text-align: left;">Due Date</th>';
        $selectedItemsTableHtml .= '<th style="text-align: center;">Status</th>';
        $selectedItemsTableHtml .= '<th style="text-align: right;">Amount (' . e($currency) . ')</th>';
        $selectedItemsTableHtml .= '<th style="text-align: right;">Paid (' . e($currency) . ')</th>';
        $selectedItemsTableHtml .= '<th style="text-align: right;">Balance (' . e($currency) . ')</th>';
        $selectedItemsTableHtml .= '</tr>';

        $rowIdx = 1;

        if (in_array('base_fee', $feeSummaryItems)) {
            $selectedItemsTableHtml .= '<tr>';
            $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
            $selectedItemsTableHtml .= '<td>Base Course Fee</td>';
            $selectedItemsTableHtml .= '<td>Tuition Base Fee</td>';
            $selectedItemsTableHtml .= '<td>N/A</td>';
            $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="color: blue; font-weight: bold;">Scheduled</span></td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($baseFee, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">0.00</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($baseFee, 2) . '</td>';
            $selectedItemsTableHtml .= '</tr>';
            $selectedItemsTotal += $baseFee;
        }

        $scholarshipAmt = (float) ($application?->scholarship_amount ?? 0);
        if (in_array('scholarship', $feeSummaryItems) && $scholarshipAmt > 0) {
            $selectedItemsTableHtml .= '<tr>';
            $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
            $selectedItemsTableHtml .= '<td>Scholarship</td>';
            $selectedItemsTableHtml .= '<td>Scholarship / Grant</td>';
            $selectedItemsTableHtml .= '<td>N/A</td>';
            $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="color: green; font-weight: bold;">Applied</span></td>';
            $selectedItemsTableHtml .= '<td style="text-align: right; color: green;">-' . number_format($scholarshipAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right; color: green;">-' . number_format($scholarshipAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">0.00</td>';
            $selectedItemsTableHtml .= '</tr>';
            $selectedItemsTotal -= $scholarshipAmt;
            $selectedItemsPaid  -= $scholarshipAmt;
        }

        $netCourseFeeAmt = (float) ($application?->net_course_fee ?? ($baseFee - $scholarshipAmt));
        if (in_array('net_course_fee', $feeSummaryItems)) {
            $selectedItemsTableHtml .= '<tr>';
            $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
            $selectedItemsTableHtml .= '<td>Course Fee</td>';
            $selectedItemsTableHtml .= '<td>Net Course Fee</td>';
            $selectedItemsTableHtml .= '<td>N/A</td>';
            $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="color: blue; font-weight: bold;">Scheduled</span></td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($netCourseFeeAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">0.00</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($netCourseFeeAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '</tr>';
            $selectedItemsTotal += $netCourseFeeAmt;
        }

        foreach ($selectedInstallments as $inst) {
            $instAmt  = (float) $inst->amount;
            $instPaid = (float) ($inst->paid_amount ?? 0);
            $instBal  = max(0, $instAmt - $instPaid);
            $statusStyle = match($inst->status) {
                'paid'           => 'color: green; font-weight: bold;',
                'partially_paid' => 'color: orange; font-weight: bold;',
                default          => 'color: red; font-weight: bold;',
            };
            $selectedItemsTableHtml .= '<tr>';
            $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
            $selectedItemsTableHtml .= '<td>Installment #' . $inst->installment_number . '</td>';
            $selectedItemsTableHtml .= '<td>Course Installment</td>';
            $selectedItemsTableHtml .= '<td>' . ($inst->due_date ? date('d M, Y', strtotime($inst->due_date)) : 'N/A') . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="' . $statusStyle . '">' . ucfirst(str_replace('_', ' ', $inst->status)) . '</span></td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instPaid, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instBal, 2) . '</td>';
            $selectedItemsTableHtml .= '</tr>';
            $selectedItemsTotal += $instAmt;
            $selectedItemsPaid  += $instPaid;
        }

        foreach ($selectedAdditionalCosts as $ac) {
            $acAmt  = (float) $ac->amount;
            $acPaid = (float) ($ac->paid_amount ?? 0);
            $acBal  = max(0, $acAmt - $acPaid);
            $acStatusStyle = ($ac->status === 'paid') ? 'color: green; font-weight: bold;' : 'color: red; font-weight: bold;';
            $selectedItemsTableHtml .= '<tr>';
            $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
            $selectedItemsTableHtml .= '<td>' . e($ac->cost_name) . '</td>';
            $selectedItemsTableHtml .= '<td>Additional Cost</td>';
            $selectedItemsTableHtml .= '<td>N/A</td>';
            $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="' . $acStatusStyle . '">' . ucfirst($ac->status ?? 'pending') . '</span></td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acAmt, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acPaid, 2) . '</td>';
            $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acBal, 2) . '</td>';
            $selectedItemsTableHtml .= '</tr>';
            $selectedItemsTotal += $acAmt;
            $selectedItemsPaid  += $acPaid;
        }

        // Fallback: If no items were selected at all, populate all installments and costs
        if ($rowIdx === 1 && $application) {
            foreach ($application->installments->sortBy('installment_number') as $inst) {
                $instAmt  = (float) $inst->amount;
                $instPaid = (float) ($inst->paid_amount ?? 0);
                $instBal  = max(0, $instAmt - $instPaid);
                $statusStyle = match($inst->status) {
                    'paid'           => 'color: green; font-weight: bold;',
                    'partially_paid' => 'color: orange; font-weight: bold;',
                    default          => 'color: red; font-weight: bold;',
                };
                $selectedItemsTableHtml .= '<tr>';
                $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
                $selectedItemsTableHtml .= '<td>Installment #' . $inst->installment_number . '</td>';
                $selectedItemsTableHtml .= '<td>Course Installment</td>';
                $selectedItemsTableHtml .= '<td>' . ($inst->due_date ? date('d M, Y', strtotime($inst->due_date)) : 'N/A') . '</td>';
                $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="' . $statusStyle . '">' . ucfirst(str_replace('_', ' ', $inst->status)) . '</span></td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instAmt, 2) . '</td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instPaid, 2) . '</td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($instBal, 2) . '</td>';
                $selectedItemsTableHtml .= '</tr>';
                $selectedItemsTotal += $instAmt;
                $selectedItemsPaid  += $instPaid;
            }

            foreach ($application->additionalCosts as $ac) {
                $acAmt  = (float) $ac->amount;
                $acPaid = (float) ($ac->paid_amount ?? 0);
                $acBal  = max(0, $acAmt - $acPaid);
                $acStatusStyle = ($ac->status === 'paid') ? 'color: green; font-weight: bold;' : 'color: red; font-weight: bold;';
                $selectedItemsTableHtml .= '<tr>';
                $selectedItemsTableHtml .= '<td>' . $rowIdx++ . '</td>';
                $selectedItemsTableHtml .= '<td>' . e($ac->cost_name) . '</td>';
                $selectedItemsTableHtml .= '<td>Additional Cost</td>';
                $selectedItemsTableHtml .= '<td>N/A</td>';
                $selectedItemsTableHtml .= '<td style="text-align: center;"><span style="' . $acStatusStyle . '">' . ucfirst($ac->status ?? 'pending') . '</span></td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acAmt, 2) . '</td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acPaid, 2) . '</td>';
                $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($acBal, 2) . '</td>';
                $selectedItemsTableHtml .= '</tr>';
                $selectedItemsTotal += $acAmt;
                $selectedItemsPaid  += $acPaid;
            }
        }

        $selectedItemsDue = max(0, $selectedItemsTotal - $selectedItemsPaid);

        if ($rowIdx === 1) {
            $selectedItemsTableHtml .= '<tr><td colspan="8" style="text-align: center; color: #888;">No specific items selected. Use {{financial_summary_table}} for full breakdown.</td></tr>';
        }

        $selectedItemsTableHtml .= '<tr style="background-color: #f8f9fa; font-weight: bold;">';
        $selectedItemsTableHtml .= '<td colspan="5">Total</td>';
        $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($selectedItemsTotal, 2) . '</td>';
        $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($selectedItemsPaid, 2) . '</td>';
        $selectedItemsTableHtml .= '<td style="text-align: right;">' . number_format($selectedItemsDue, 2) . '</td>';
        $selectedItemsTableHtml .= '</tr></table>';

        // ---- Selected Items Simple 2-Column Format (matching simple template layouts) ----
        $selectedItemsListHtml  = '<table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; font-size: 13px;" border="1" cellpadding="8">';
        $selectedItemsListHtml .= '<tr style="background-color: #f2f2f2; font-weight: bold;"><th style="text-align: left;">Description</th><th style="text-align: right;">Amount (' . e($currency) . ')</th></tr>';

        if (in_array('base_fee', $feeSummaryItems)) {
            $selectedItemsListHtml .= '<tr><td>Base Course Fee</td><td style="text-align: right;">' . number_format($baseFee, 2) . '</td></tr>';
        }
        if (in_array('scholarship', $feeSummaryItems) && $scholarshipAmt > 0) {
            $selectedItemsListHtml .= '<tr><td>Scholarship Discount</td><td style="text-align: right; color: green;">-' . number_format($scholarshipAmt, 2) . '</td></tr>';
        }
        if (in_array('net_course_fee', $feeSummaryItems)) {
            $selectedItemsListHtml .= '<tr><td>Course Fee</td><td style="text-align: right;">' . number_format($netCourseFeeAmt, 2) . '</td></tr>';
        }
        foreach ($selectedInstallments as $inst) {
            $dueStr = $inst->due_date ? ' (Due: ' . date('d M, Y', strtotime($inst->due_date)) . ')' : '';
            $selectedItemsListHtml .= '<tr><td>Installment #' . $inst->installment_number . $dueStr . '</td><td style="text-align: right;">' . number_format($inst->amount, 2) . '</td></tr>';
        }
        foreach ($selectedAdditionalCosts as $ac) {
            $selectedItemsListHtml .= '<tr><td>' . e($ac->cost_name) . '</td><td style="text-align: right;">' . number_format($ac->amount, 2) . '</td></tr>';
        }
        // ---- Selected Items Inline Text & Bullet List Formats (for Paragraph/Letter Layouts) ----
        $itemNamesArr = [];
        $itemListTextArr = [];

        if (in_array('base_fee', $feeSummaryItems)) {
            $itemNamesArr[] = 'Base Course Fee';
            $itemListTextArr[] = 'Base Course Fee: ' . $currency . ' ' . number_format($baseFee, 2);
        }
        if (in_array('scholarship', $feeSummaryItems) && $scholarshipAmt > 0) {
            $itemNamesArr[] = 'Scholarship Discount';
            $itemListTextArr[] = 'Scholarship Discount: -' . $currency . ' ' . number_format($scholarshipAmt, 2);
        }
        if (in_array('net_course_fee', $feeSummaryItems)) {
            $itemNamesArr[] = 'Course Fee';
            $itemListTextArr[] = 'Course Fee: ' . $currency . ' ' . number_format($netCourseFeeAmt, 2);
        }
        foreach ($selectedInstallments as $inst) {
            $nameStr = 'Installment #' . $inst->installment_number;
            $itemNamesArr[] = $nameStr;
            $dueStr = $inst->due_date ? ' (Due: ' . date('d M, Y', strtotime($inst->due_date)) . ')' : '';
            $itemListTextArr[] = $nameStr . $dueStr . ': ' . $currency . ' ' . number_format($inst->amount, 2);
        }
        foreach ($selectedAdditionalCosts as $ac) {
            $itemNamesArr[] = $ac->cost_name;
            $itemListTextArr[] = $ac->cost_name . ': ' . $currency . ' ' . number_format($ac->amount, 2);
        }

        $selectedItemsNames = !empty($itemNamesArr) ? implode(', ', $itemNamesArr) : 'Selected Fee Items';
        $selectedItemsText  = !empty($itemListTextArr) ? '<ul style="margin-top:5px; margin-bottom:10px;"><li>' . implode('</li><li>', $itemListTextArr) . '</li></ul>' : '';

        // Dynamic HTML table for Financial Summary
        $financialSummaryTableHtml = '
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; font-size: 13px;" border="1" cellpadding="8">
            <tr style="background-color: #003366; color: #ffffff;">
                <th style="text-align: left;">Financial Breakdown</th>
                <th style="text-align: right;">Amount (' . e($currency) . ')</th>
            </tr>
            <tr>
                <td><strong>Course Base Fee:</strong> ' . e($courseName) . ' (' . e($courseCode) . ')</td>
                <td style="text-align: right;">' . number_format($baseFee, 2) . '</td>
            </tr>';
        foreach ($additionalCostsList as $ac) {
            $financialSummaryTableHtml .= '
            <tr>
                <td><strong>Additional Cost:</strong> ' . e($ac->cost_name) . '</td>
                <td style="text-align: right;">' . number_format($ac->amount, 2) . '</td>
            </tr>';
        }
        $financialSummaryTableHtml .= '
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td>Grand Total Fee</td>
                <td style="text-align: right;">' . number_format($grandTotal, 2) . '</td>
            </tr>
        </table>';

        if ($application && $application->installments->count() > 0) {
            $financialSummaryTableHtml .= '
            <h4 style="margin-top: 20px; margin-bottom: 8px; color: #003366;">Payment Installment Schedule</h4>
            <table style="width: 100%; border-collapse: collapse; font-size: 12px;" border="1" cellpadding="6">
                <tr style="background-color: #eef6ff;">
                    <th>Installment #</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th style="text-align: right;">Scheduled Amount</th>
                    <th style="text-align: right;">Paid Amount</th>
                </tr>';
            foreach ($application->installments->sortBy('installment_number') as $inst) {
                $statusBadge = ($inst->status === 'paid') ? '<span style="color: green; font-weight: bold;">Paid</span>' : (($inst->status === 'partially_paid') ? '<span style="color: orange; font-weight: bold;">Partially Paid</span>' : '<span style="color: red; font-weight: bold;">Pending</span>');
                $financialSummaryTableHtml .= '
                <tr>
                    <td>Installment ' . $inst->installment_number . '</td>
                    <td>' . ($inst->due_date ? date('d M, Y', strtotime($inst->due_date)) : 'N/A') . '</td>
                    <td>' . $statusBadge . '</td>
                    <td style="text-align: right;">' . $currency . ' ' . number_format($inst->amount, 2) . '</td>
                    <td style="text-align: right;">' . $currency . ' ' . number_format($inst->paid_amount, 2) . '</td>
                </tr>';
            }
            $financialSummaryTableHtml .= '</table>';
        }

        // Dynamic HTML table for Payment Receipt
        $paymentReceiptTableHtml = '
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; font-size: 13px;" border="1" cellpadding="8">
            <tr style="background-color: #d4edda; color: #155724;">
                <th>Item / Description</th>
                <th>Status</th>
                <th style="text-align: right;">Amount Paid</th>
            </tr>
            <tr>
                <td>' . e($courseName) . '<br><small>Payment for ' . e($instNumberText) . '</small></td>
                <td>' . e($instStatusText) . '</td>
                <td style="text-align: right; font-weight: bold; color: #155724;">' . e($instPaidText) . '</td>
            </tr>
        </table>';

        // 1. Admin Signature
        if (str_contains($content, '{{admin_signature}}')) {
            if ($currentUser && $currentUser->signature && file_exists(public_path($currentUser->signature))) {
                $this->activeSignatures[] = [
                    'path'        => public_path($currentUser->signature),
                    'name'        => $issuerName,
                    'designation' => $issuerDesig,
                    'type'        => 'signature'
                ];
            }
            // Remove the inline tag — signature image shown via fixed block above footer
            $content = str_replace('{{admin_signature}}', '', $content);
        }

        // 2. Student Signature
        if (str_contains($content, '{{student_signature}}')) {
            $studentUser = $student->user ?? null;
            if ($studentUser && $studentUser->signature && file_exists(public_path($studentUser->signature))) {
                $this->activeSignatures[] = [
                    'path'        => public_path($studentUser->signature),
                    'name'        => $fullName,
                    'designation' => 'Student',
                    'type'        => 'signature'
                ];
            }
            // Remove the inline tag — signature image shown via fixed block above footer
            $content = str_replace('{{student_signature}}', '', $content);
        }

        // 3. Dynamic Official Signatures & Seals
        $officialSignatures = \App\Models\OfficialSignature::where('status', 'active')->get();
        foreach ($officialSignatures as $offSig) {
            if (str_contains($content, $offSig->tag)) {
                if (file_exists(public_path($offSig->signature_path))) {
                    $this->activeSignatures[] = [
                        'path'        => public_path($offSig->signature_path),
                        'name'        => $offSig->name,
                        'designation' => $offSig->designation ?? 'Authorized Signatory',
                        'type'        => $offSig->type
                    ];
                }
                
                $label = $offSig->type === 'seal' ? 'Official Seal' : ($offSig->name . ' - ' . ($offSig->designation ?? 'Authorized Signatory'));
                $content = str_replace($offSig->tag, '<span style="font-weight: bold; font-family: Arial, sans-serif; font-size: 13px; color: #333;">' . e($label) . '</span>', $content);
            }
        }

        $hasCustomSelections = (!empty($installmentIds) || !empty($additionalCostIds) || !empty($feeSummaryItems));

        if ($hasCustomSelections) {
            // Replace financial_summary_table with selected_items_table if custom selections exist
            if (str_contains($content, '{{financial_summary_table}}')) {
                $content = str_replace('{{financial_summary_table}}', $selectedItemsTableHtml, $content);
            }
            // Replace payment_receipt_table with selected_items_table if custom selections exist
            if (str_contains($content, '{{payment_receipt_table}}')) {
                $content = str_replace('{{payment_receipt_table}}', $selectedItemsTableHtml, $content);
            }
            // If template body has neither selected_items_table nor financial_summary_table, auto-append the table
            if (!str_contains($content, '{{selected_items_table}}') && !str_contains($content, $selectedItemsTableHtml)) {
                $content .= '<div style="margin-top: 15px; margin-bottom: 15px;"><h4 style="color: #003366; margin-bottom: 8px;">Selected Fee Breakdown</h4>' . $selectedItemsTableHtml . '</div>';
            }
        }

        // Standard Placeholders
        $placeholders = [
            '{{student_name}}'            => $fullName,
            '{{student_id}}'              => $student->student_id ?? $student->student_code ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)),
            '{{email}}'                   => $student->email ?? 'N/A',
            '{{phone}}'                   => $student->phone ?? 'N/A',
            '{{passport_number}}'         => $student->passport_number ?? 'N/A',
            '{{dob}}'                     => $student->dob ? date('d M, Y', strtotime($student->dob)) : 'N/A',
            '{{gender}}'                  => ucfirst($student->gender ?? 'N/A'),
            '{{nationality}}'             => $student->nationality ?? 'N/A',
            '{{today_date}}'              => date('d M, Y'),
            '{{institute_name}}'          => $student->institute?->name ?? 'iLAP Group',
            '{{course_name}}'             => $courseName,
            '{{course_code}}'             => $courseCode,
            '{{currency}}'                => $currency,
            '{{course_fee}}'              => $currency . ' ' . number_format($baseFee, 2),
            '{{additional_costs}}'        => $addCostsText,
            '{{total_fee}}'               => $currency . ' ' . number_format($grandTotal, 2),
            '{{grand_total}}'             => $currency . ' ' . number_format($grandTotal, 2),
            '{{paid_amount}}'             => $currency . ' ' . number_format($paidAmountTotal, 2),
            '{{due_amount}}'              => $currency . ' ' . number_format($dueAmountTotal, 2),
            '{{installment_number}}'      => $instNumberText,
            '{{installment_amount}}'      => $instAmountText,
            '{{installment_due_date}}'   => $instDueDateText,
            '{{installment_status}}'      => $instStatusText,
            '{{installment_paid_amount}}' => $instPaidText,
            '{{installment_balance_due}}' => $instBalanceText,
            '{{payment_date}}'            => date('d M, Y'),
            '{{payment_receipt_no}}'      => $receiptNo,
            '{{financial_summary_table}}' => $financialSummaryTableHtml,
            '{{payment_receipt_table}}'   => $paymentReceiptTableHtml,
            '{{selected_items_table}}'    => $selectedItemsTableHtml,
            '{{selected_items_list}}'     => $selectedItemsListHtml,
            '{{selected_items_names}}'    => $selectedItemsNames,
            '{{selected_items_text}}'     => $selectedItemsText,
            '{{selected_items_total}}'    => $currency . ' ' . number_format($selectedItemsTotal, 2),
            '{{selected_items_paid}}'     => $currency . ' ' . number_format($selectedItemsPaid, 2),
            '{{selected_items_due}}'      => $currency . ' ' . number_format($selectedItemsDue, 2),
            '{{address}}'                 => $student->permanent_address ?? $student->address ?? 'N/A',
            '{{issuer_name}}'             => $issuerName,
        ];

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    /**
     * Render dynamic live preview for modal.
     */
    public function previewModal(Request $request, Student $student)
    {
        $templateId        = $request->query('template_id');
        $installmentId     = $request->query('installment_id');
        $installmentIds    = array_filter((array) $request->query('installment_ids', []));
        $additionalCostIds = array_filter((array) $request->query('additional_cost_ids', []));
        $feeSummaryItems   = array_filter((array) $request->query('fee_summary_items', []));
        $template = InvoiceTemplate::find($templateId);

        if (!$template) {
            return response()->json(['success' => false, 'html' => '<div class="alert alert-warning">Please select a valid template.</div>']);
        }

        $parsedContent = $this->parsePlaceholders($template->content_body, $student, true, $installmentId ? (int)$installmentId : null, $installmentIds, $additionalCostIds, $feeSummaryItems);
        $parsedSubject = $this->parsePlaceholders($template->subject ?? '', $student, false, $installmentId ? (int)$installmentId : null, $installmentIds, $additionalCostIds, $feeSummaryItems);

        return response()->json([
            'success' => true,
            'subject' => $parsedSubject,
            'content' => $parsedContent
        ]);
    }

    /**
     * Generate Invoice (from Template OR from Uploaded DOCX/PDF/Image file).
     */
    public function generate(Request $request, Student $student)
    {
        $request->validate([
            'generation_type'       => 'required|in:template,file_upload',
            'invoice_template_id'   => 'required_if:generation_type,template',
            'installment_id'        => 'nullable|exists:student_application_installments,id',
            'installment_ids'       => 'nullable|array',
            'installment_ids.*'     => 'exists:student_application_installments,id',
            'additional_cost_ids'   => 'nullable|array',
            'additional_cost_ids.*' => 'exists:student_application_additional_costs,id',
            'fee_summary_items'     => 'nullable|array',
            'uploaded_file'         => 'nullable|file|mimes:docx,pdf,jpg,jpeg,png|max:10240',
            'custom_content'        => 'nullable|string',
            'invoice_action'        => 'nullable|in:download,send',
        ]);

        $action            = $request->invoice_action ?? 'download';
        $installmentId     = $request->input('installment_id');
        $installmentIds    = array_filter($request->input('installment_ids', []));
        $additionalCostIds = array_filter($request->input('additional_cost_ids', []));
        $feeSummaryItems   = array_filter($request->input('fee_summary_items', []));

        if ($request->generation_type === 'template') {
            $template = InvoiceTemplate::findOrFail($request->invoice_template_id);

            $contentBody = $request->filled('custom_content')
                ? $request->custom_content
                : $template->content_body;

            $parsedContent = $this->parsePlaceholders($contentBody, $student, true, $installmentId ? (int)$installmentId : null, $installmentIds, $additionalCostIds, $feeSummaryItems);
            $parsedSubject = $this->parsePlaceholders($template->subject ?? $template->title, $student, false, $installmentId ? (int)$installmentId : null, $installmentIds, $additionalCostIds, $feeSummaryItems);

            // Generate PDF
            $pdf = Pdf::loadView('backend.pdf.invoice_layout', [
                'content'          => $parsedContent,
                'title'            => $parsedSubject,
                'header_image'     => $template->header_image,
                'footer_image'     => $template->footer_image,
                'student'          => $student,
                'activeSignatures' => $this->activeSignatures
            ]);

            $fileName = 'generated_invoices/' . $student->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            // Save record in history
            GeneratedInvoice::create([
                'student_id'          => $student->id,
                'invoice_template_id' => $template->id,
                'invoice_title'       => $template->title,
                'file_path'           => $fileName,
                'file_type'           => 'pdf',
                'generated_by'        => auth()->id(),
                'sent_to_student'     => $action === 'send',
                'sent_at'             => $action === 'send' ? now() : null,
            ]);

            // Mark selected installments and additional costs as invoiced ONLY if sent to student
            if ($action === 'send') {
                if (!empty($installmentIds)) {
                    \App\Models\StudentApplicationInstallment::whereIn('id', $installmentIds)
                        ->update(['is_invoiced' => true, 'invoiced_at' => now()]);
                }
                if (!empty($additionalCostIds)) {
                    \App\Models\StudentApplicationAdditionalCost::whereIn('id', $additionalCostIds)
                        ->update(['is_invoiced' => true, 'invoiced_at' => now()]);
                }
            }

            if ($action === 'send') {
                return redirect()->route('admin.students.show', $student->id)
                    ->with('success', 'Invoice "' . $template->title . '" has been sent to student\'s profile successfully!');
            }

            return response()->download(storage_path('app/public/' . $fileName));

        } else if ($request->hasFile('uploaded_file')) {
            $file = $request->file('uploaded_file');
            $ext = strtolower($file->getClientOriginalExtension());

            if ($ext === 'docx') {
                // Word Template processing using PHPWord
                $templateProcessor = new TemplateProcessor($file->getRealPath());

                $fullName = trim(($student->first_name ?? '') . ' ' . ($student->last_name ?? ''));
                if (empty($fullName)) {
                    $fullName = $student->name ?? 'Student';
                }

                $templateProcessor->setValue('student_name', $fullName);
                $templateProcessor->setValue('student_id', $student->student_code ?? ('STU-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)));
                $templateProcessor->setValue('email', $student->email ?? '');
                $templateProcessor->setValue('phone', $student->phone ?? '');
                $templateProcessor->setValue('passport_number', $student->passport_number ?? '');
                $templateProcessor->setValue('today_date', date('d M, Y'));
                $templateProcessor->setValue('institute_name', $student->institute->name ?? '');
                $templateProcessor->setValue('course_name', $student->course->name ?? '');

                $fileName = 'generated_invoices/docx_' . $student->id . '_' . time() . '.docx';
                $outputPath = storage_path('app/public/' . $fileName);
                $templateProcessor->saveAs($outputPath);

                GeneratedInvoice::create([
                    'student_id'          => $student->id,
                    'invoice_template_id' => null,
                    'invoice_title'       => 'Custom DOCX Invoice (' . $file->getClientOriginalName() . ')',
                    'file_path'           => $fileName,
                    'file_type'           => 'docx',
                    'generated_by'        => auth()->id(),
                ]);

                return response()->download($outputPath);

            } else {
                // Image or PDF direct attachment/save
                $fileName = $file->store('generated_invoices', 'public');

                GeneratedInvoice::create([
                    'student_id'          => $student->id,
                    'invoice_template_id' => null,
                    'invoice_title'       => 'Uploaded Invoice (' . $file->getClientOriginalName() . ')',
                    'file_path'           => $fileName,
                    'file_type'           => $ext,
                    'generated_by'        => auth()->id(),
                    'sent_to_student'     => $action === 'send',
                    'sent_at'             => $action === 'send' ? now() : null,
                ]);

                if ($action === 'send') {
                    return redirect()->route('admin.students.show', $student->id)
                        ->with('success', 'Uploaded invoice has been sent to student\'s profile successfully!');
                }

                return response()->download(storage_path('app/public/' . $fileName));
            }
        }

        return back()->with('error', 'Unable to generate invoice. Please select a template or upload a file.');
    }

    /**
     * Download a previously generated invoice.
     */
    public function downloadHistory(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            return Storage::disk('public')->download($generatedInvoice->file_path);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Preview a generated invoice inline in browser.
     */
    public function previewInvoice(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            $filePath = storage_path('app/public/' . $generatedInvoice->file_path);
            return response()->file($filePath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . basename($generatedInvoice->file_path) . '"',
            ]);
        }

        return back()->with('error', 'File not found on server.');
    }

    /**
     * Mark an existing generated invoice as sent to student.
     */
    public function sendToStudent(GeneratedInvoice $generatedInvoice)
    {
        $generatedInvoice->update([
            'sent_to_student' => true,
            'sent_at'         => now(),
        ]);

        return back()->with('success', 'Invoice "' . $generatedInvoice->invoice_title . '" has been sent to the student\'s profile successfully!');
    }

    /**
     * Delete generated invoice record.
     */
    public function deleteHistory(GeneratedInvoice $generatedInvoice)
    {
        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            Storage::disk('public')->delete($generatedInvoice->file_path);
        }

        $generatedInvoice->delete();

        return back()->with('success', 'Invoice history record deleted successfully.');
    }
}
