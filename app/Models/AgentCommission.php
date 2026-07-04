<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id', 'course_id', 'commission_type', 'amount', 'currency'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function agent() { return $this->belongsTo(Agent::class); }
    public function course() { return $this->belongsTo(Course::class); }
}