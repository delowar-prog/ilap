<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'course_id', 'assigned_agent_id', 'stage', 'total_fee', 'paid_amount'
    ];

    protected $casts = [
        'total_fee' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function student() { return $this->belongsTo(Student::class); }
    public function course() { return $this->belongsTo(Course::class); }
    public function assignedAgent() { return $this->belongsTo(Agent::class, 'assigned_agent_id'); }
    
    // Commission Transaction (One-to-One)
    public function commissionTransaction() { return $this->hasOne(CommissionTransaction::class, 'application_id'); }

    public function additionalCosts()
    {
        return $this->hasMany(StudentApplicationAdditionalCost::class, 'student_application_id');
    }

    public function installments()
    {
        return $this->hasMany(StudentApplicationInstallment::class, 'student_application_id');
    }
}