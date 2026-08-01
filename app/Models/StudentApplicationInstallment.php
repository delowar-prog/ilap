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
        'is_invoiced',
        'invoiced_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'is_invoiced' => 'boolean',
        'invoiced_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(StudentApplication::class, 'student_application_id');
    }
}
