<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentReferee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'full_name', 'job_title', 'email', 'mobile',
        'organization_name', 'organization_address', 'how_long_known', 'relationship',
    ];

    public function student() { return $this->belongsTo(Student::class); }
}
