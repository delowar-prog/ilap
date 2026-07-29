<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplicationInstallment extends Model
{
    use HasFactory;

    protected $table = 'student_application_installments';

    protected $fillable = [
        'student_application_id',
        'installment_number',
        'amount',
        'due_date',
        'status',
        'paid_amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    public function application()
    {
        return $this->belongsTo(StudentApplication::class, 'student_application_id');
    }
}
