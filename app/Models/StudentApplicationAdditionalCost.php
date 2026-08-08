<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplicationAdditionalCost extends Model
{
    use HasFactory;

    protected $table = 'student_application_additional_costs';

    protected $fillable = [
        'student_application_id',
        'cost_name',
        'amount',
        'note',
        'status',
        'paid_amount',
        'paid_at',
        'payment_method',
        'transaction_id',
        'is_invoiced',
        'invoiced_at',
        'refunded_amount',
        'deducted_amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'refunded_amount' => 'decimal:2',
        'deducted_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'is_invoiced' => 'boolean',
        'invoiced_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(StudentApplication::class, 'student_application_id');
    }
}
