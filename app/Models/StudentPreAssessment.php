<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPreAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        // Page 1: Personal Info
        'full_name', 'contact_number', 'contact_address', 'city', 'state', 'postal_code', 'country', 'dob', 'passport_number',
        'gender', 'nationality',
        // Page 2: Academic
        'highest_qualification', 'grades_gpa', 'field_of_study',
        'name_of_institution', 'year_of_passing',
        'second_qualification', 'second_qual_grade',
        'second_institution', 'second_year_of_passing',
        'english_test', 'english_score', 'english_proficiency', 'english_test_details',
        'native_language', 'work_experience',
        // Page 3: Study Plan
        'intended_course', 'course_link', 'level_of_study', 'institute_name',
        'study_method', 'country_of_choice', 'study_destination',
        'preferred_intake',
        'purpose_of_study', 'source_of_funding', 'financial_source',
        'visa_refusal_history', 'previous_uk_study_history',
        'cv_path', 'intake_date',
        // Extra
        'preferred_course_2', 'preferred_course_3',
        'preferred_university_2', 'preferred_university_3',
        'course_link_2', 'course_link_3',
        // Approval Workflow
        'assessment_status', 'approved_by', 'approved_at', 'rejection_note',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'intake_date'  => 'date',
    ];

    // ─── Relationships ───
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // ─── Helpers ───
    public function isPending(): bool   { return $this->assessment_status === 'pending'; }
    public function isApproved(): bool  { return $this->assessment_status === 'approved'; }
    public function isRejected(): bool  { return $this->assessment_status === 'rejected'; }
    public function isSubmitted(): bool { return in_array($this->assessment_status, ['pending','approved','rejected']); }
}