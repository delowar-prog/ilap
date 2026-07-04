<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id', 'master_agent_id', 'sub_agent_id', 'total_commission', 
        'master_commission', 'sub_commission', 'currency', 'status', 
        'master_paid_date', 'master_receipt_path', 'sub_paid_date', 'sub_receipt_path', 'hq_notes'
    ];

    protected $casts = [
        'total_commission' => 'decimal:2',
        'master_commission' => 'decimal:2',
        'sub_commission' => 'decimal:2',
        'master_paid_date' => 'date',
        'sub_paid_date' => 'date',
    ];

    public function application() { return $this->belongsTo(StudentApplication::class, 'application_id'); }
    public function masterAgent() { return $this->belongsTo(Agent::class, 'master_agent_id'); }
    public function subAgent() { return $this->belongsTo(Agent::class, 'sub_agent_id'); }
}