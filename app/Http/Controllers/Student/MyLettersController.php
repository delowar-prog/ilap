<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GeneratedLetter;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyLettersController extends Controller
{
    /**
     * Show all letters sent to the authenticated student.
     */
    public function index()
    {
        $user = Auth::user();

        // Find the student profile linked to this user
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return view('student.my_letters', ['letters' => collect()]);
        }

        $letters = GeneratedLetter::where('student_id', $student->id)
            ->where('sent_to_student', true)
            ->with('generator')
            ->get()
            ->map(function ($item) {
                $item->doc_type = 'letter';
                return $item;
            });

        $invoices = \App\Models\GeneratedInvoice::where('student_id', $student->id)
            ->where('sent_to_student', true)
            ->with('generator')
            ->get()
            ->map(function ($item) {
                $item->doc_type = 'invoice';
                return $item;
            });

        $letters = $letters->concat($invoices)->sortByDesc(function ($item) {
            return $item->sent_at ?? $item->created_at;
        });

        return view('student.my_letters', compact('letters'));
    }

    /**
     * Download a letter (only if it belongs to this student and was sent).
     */
    public function download(GeneratedLetter $generatedLetter)
    {
        $this->authorizeLetterAccess($generatedLetter);

        if (Storage::disk('public')->exists($generatedLetter->file_path)) {
            return Storage::disk('public')->download(
                $generatedLetter->file_path,
                $generatedLetter->letter_title . '.' . $generatedLetter->file_type
            );
        }

        return back()->with('error', 'File not found. Please contact the administration.');
    }

    /**
     * Preview a letter inline in browser.
     */
    public function preview(GeneratedLetter $generatedLetter)
    {
        $this->authorizeLetterAccess($generatedLetter);

        if (Storage::disk('public')->exists($generatedLetter->file_path)) {
            $filePath = storage_path('app/public/' . $generatedLetter->file_path);
            return response()->file($filePath, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $generatedLetter->letter_title . '.pdf"',
            ]);
        }

        return back()->with('error', 'File not found. Please contact the administration.');
    }

    /**
     * Ensure the letter belongs to the authenticated student and was sent.
     */
    private function authorizeLetterAccess(GeneratedLetter $generatedLetter): void
    {
        $user    = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        abort_if(
            !$student
            || $generatedLetter->student_id !== $student->id
            || !$generatedLetter->sent_to_student,
            403,
            'You are not authorized to access this document.'
        );
    }
}
