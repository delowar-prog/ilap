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
        'note',
        'status',
        'paid_amount',
        'is_invoiced',
        'invoiced_at',
        'paid_at',
        'payment_method',
        'transaction_id',
        'attachment',
        'pending_paid_amount',
        'approval_status',
        'refunded_amount',
        'deducted_amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'deducted_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'is_invoiced' => 'boolean',
        'invoiced_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(StudentApplication::class, 'student_application_id');
    }
}
