<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GeneratedInvoice;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyInvoicesController extends Controller
{
    /**
     * Download an invoice (only if it belongs to this student and was sent).
     */
    public function download(GeneratedInvoice $generatedInvoice)
    {
        $this->authorizeInvoiceAccess($generatedInvoice);

        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            return Storage::disk('public')->download(
                $generatedInvoice->file_path,
                $generatedInvoice->invoice_title . '.' . $generatedInvoice->file_type
            );
        }

        return back()->with('error', 'File not found. Please contact the administration.');
    }

    /**
     * Preview an invoice inline in browser.
     */
    public function preview(GeneratedInvoice $generatedInvoice)
    {
        $this->authorizeInvoiceAccess($generatedInvoice);

        if (Storage::disk('public')->exists($generatedInvoice->file_path)) {
            $filePath = storage_path('app/public/' . $generatedInvoice->file_path);
            return response()->file($filePath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $generatedInvoice->invoice_title . '.pdf"',
            ]);
        }

        return back()->with('error', 'File not found. Please contact the administration.');
    }

    /**
     * Ensure the invoice belongs to the authenticated student and was sent.
     */
    private function authorizeInvoiceAccess(GeneratedInvoice $generatedInvoice): void
    {
        $user    = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        abort_if(
            !$student
            || $generatedInvoice->student_id !== $student->id
            || !$generatedInvoice->sent_to_student,
            403,
            'You are not authorized to access this document.'
        );
    }
}
