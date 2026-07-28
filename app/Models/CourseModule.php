<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'code',
        'title',
        'credit',
        'glh',
        'is_mandatory',
        'priority',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'priority' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
