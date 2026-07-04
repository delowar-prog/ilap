<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id', 'user_id', 'agent_id', 'student_id', 'promo_code', 'title', 
        'first_name', 'middle_name', 'surname', 'dob', 'nationality', 'email', 
        'phone', 'password', 'status'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public function campus() { return $this->belongsTo(Campus::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function agent() { return $this->belongsTo(Agent::class); } // রেফারেল এজেন্ট
    
    public function preAssessment() { return $this->hasOne(StudentPreAssessment::class); }
    public function applications() { return $this->hasMany(StudentApplication::class); }
}