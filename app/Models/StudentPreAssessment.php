<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPreAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'highest_qualification', 'grades_gpa', 'field_of_study',
        'english_test', 'english_score', 'native_language', 'intended_course',
        'level_of_study', 'institute_name', 'study_method', 'country_of_choice',
        'purpose_of_study', 'source_of_funding', 'cv_path',
        // New fields
        'preferred_course_2', 'preferred_course_3',
        'preferred_university_2', 'preferred_university_3', 'intake_date',
    ];

    public function student() { return $this->belongsTo(Student::class); }
}