<?php

namespace Database\Seeders;

use App\Models\InvoiceTemplate;
use Illuminate\Database\Seeder;

class InvoiceTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'title'        => 'Course Enrolment & 1st Installment Invoice',
                'type'         => 'tuition_fee',
                'subject'      => 'INVOICE FOR COURSE ENROLMENT & 1ST INSTALLMENT',
                'content_body' => "<p><strong>To:</strong><br>
Student Name: <strong>{{student_name}}</strong><br>
Student ID: <strong>{{student_id}}</strong><br>
Passport No: {{passport_number}}<br>
Email: {{email}} | Phone: {{phone}}</p>

<p>Dear <strong>{{student_name}}</strong>,</p>

<p>Thank you for enrolling at <strong>{{institute_name}}</strong>. Please find below the invoice for your course enrolment and 1st payment installment.</p>

<table style=\"width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 15px; font-size: 13px;\" border=\"1\" cellpadding=\"8\">
    <tr style=\"background-color: #f2f2f2;\">
        <th style=\"text-align: left;\">Description</th>
        <th style=\"text-align: right;\">Amount</th>
    </tr>
    <tr>
        <td><strong>Assigned Course:</strong> {{course_name}} ({{course_code}})</td>
        <td style=\"text-align: right;\">{{course_fee}}</td>
    </tr>
    <tr>
        <td><strong>Additional Enrolment / Admin Costs:</strong><br>{{additional_costs}}</td>
        <td style=\"text-align: right;\">-</td>
    </tr>
    <tr style=\"background-color: #f8f9fa; font-weight: bold;\">
        <td>Total Course Fee</td>
        <td style=\"text-align: right;\">{{total_fee}}</td>
    </tr>
</table>

<div style=\"background-color: #eef6ff; border-left: 4px solid #003366; padding: 12px; margin-bottom: 20px;\">
    <h4 style=\"margin: 0 0 5px 0; color: #003366;\">Payment Details for 1st Installment</h4>
    <p style=\"margin: 0;\">
        <strong>Installment:</strong> {{installment_number}}<br>
        <strong>Amount Payable:</strong> <span style=\"font-size: 16px; color: #d9534f; font-weight: bold;\">{{installment_amount}}</span><br>
        <strong>Due Date:</strong> {{installment_due_date}}<br>
        <strong>Status:</strong> {{installment_status}}
    </p>
</div>

<p>Please ensure payment is completed on or before the due date. For bank transfer or online payment options, please contact our finance desk.</p>

<p>Sincerely,<br>
<strong>Finance & Accounts Department</strong><br>
{{institute_name}}</p>",
                'status'       => true,
            ],
            [
                'title'        => 'Official Payment Receipt',
                'type'         => 'payment_receipt',
                'subject'      => 'OFFICIAL PAYMENT RECEIPT',
                'content_body' => "<p><strong>RECEIPT REF NO:</strong> {{payment_receipt_no}}<br>
<strong>Date:</strong> {{payment_date}}</p>

<p><strong>Received From:</strong><br>
Student Name: <strong>{{student_name}}</strong> (Student ID: {{student_id}})<br>
Passport No: {{passport_number}}</p>

<div style=\"background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; padding: 15px; margin-top: 15px; margin-bottom: 20px;\">
    <h3 style=\"margin-top: 0; color: #155724;\">Payment Received with Thanks</h3>
    <p style=\"font-size: 14px; margin-bottom: 5px;\">
        <strong>Course:</strong> {{course_name}} ({{course_code}})<br>
        <strong>Payment Purpose / Installment:</strong> {{installment_number}}<br>
        <strong>Amount Received:</strong> <span style=\"font-size: 18px; color: #155724; font-weight: bold;\">{{installment_paid_amount}}</span><br>
        <strong>Payment Status:</strong> {{installment_status}}
    </p>
</div>

<table style=\"width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 13px;\" border=\"1\" cellpadding=\"8\">
    <tr style=\"background-color: #f8f9fa;\">
        <td>Total Course Fee:</td>
        <td style=\"text-align: right; font-weight: bold;\">{{total_fee}}</td>
    </tr>
    <tr>
        <td>Total Amount Paid to Date:</td>
        <td style=\"text-align: right; font-weight: bold; color: #28a745;\">{{paid_amount}}</td>
    </tr>
    <tr style=\"background-color: #fff3cd;\">
        <td><strong>Remaining Balance Due:</strong></td>
        <td style=\"text-align: right; font-weight: bold; color: #856404;\">{{due_amount}}</td>
    </tr>
</table>

<p>Thank you for your payment.</p>

<p>Authorized Signature,<br>
<strong>Accounts & Billing Division</strong><br>
{{institute_name}}</p>",
                'status'       => true,
            ],
            [
                'title'        => 'Full Tuition Fee & Payment Schedule Invoice',
                'type'         => 'tuition_fee',
                'subject'      => 'FULL COURSE TUITION FEE & PAYMENT SCHEDULE INVOICE',
                'content_body' => "<p><strong>To:</strong><br>
Student Name: <strong>{{student_name}}</strong><br>
Student ID: <strong>{{student_id}}</strong> | Passport: {{passport_number}}</p>

<p>Dear <strong>{{student_name}}</strong>,</p>

<p>Here is your full course tuition fee calculation and payment schedule breakdown for <strong>{{course_name}}</strong> at {{institute_name}}.</p>

{{financial_summary_table}}

<p style=\"margin-top: 20px;\">Please adhere to the installment due dates specified above to avoid any academic hold on your account.</p>

<p>Warm regards,<br>
<strong>Finance & Admissions Office</strong><br>
{{institute_name}}</p>",
                'status'       => true,
            ],
        ];

        foreach ($templates as $tpl) {
            InvoiceTemplate::firstOrCreate(
                ['title' => $tpl['title']],
                $tpl
            );
        }
    }
}
