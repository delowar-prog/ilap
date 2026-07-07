<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnglishTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'test_name', 'date_of_exam', 'listening', 'reading',
        'writing', 'speaking', 'overall_score', 'cefr_level', 'ukvi_number', 'trf_number',
    ];

    protected $casts = [
        'date_of_exam' => 'date',
    ];

    public function student() { return $this->belongsTo(Student::class); }
}
