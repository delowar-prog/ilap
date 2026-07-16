<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAcademic extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'education_level', 'country', 'city', 'zip_code', 'institution_name',
        'institution_address', 'course_name', 'start_date', 'end_date',
        'award_date', 'result_type', 'other_result_type', 'result_percentage', 'gpa', 'result_out_of',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'award_date' => 'date',
    ];

    public function student() { return $this->belongsTo(Student::class); }
}
