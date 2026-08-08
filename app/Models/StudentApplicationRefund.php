<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentApplicationRefund extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'refund_type',
        'item_id',
        'original_paid_amount',
        'deduction_percentage',
        'deduction_amount',
        'refund_amount',
        'reason_note',
        'processed_by',
        'refunded_at',
    ];

    protected $casts = [
        'original_paid_amount' => 'decimal:2',
        'deduction_percentage' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'refunded_at' => 'datetime',
    ];

    public function application()
    {
        return $this->belongsTo(StudentApplication::class, 'application_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
