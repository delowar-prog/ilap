<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id', 'user_id', 'parent_agent_id', 'agent_code', 'agent_type',
        'name', 'first_name', 'middle_name', 'last_name',
        'email', 'phone', 'phone_code', 'photo', 'logo', 'status',
    ];

    /** Full name assembled from split fields (falls back to legacy name) */
    public function getFullNameAttribute(): string
    {
        if ($this->first_name) {
            return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
        }
        return $this->name ?? '';
    }

    // Relationships
    public function campus() { return $this->belongsTo(Campus::class); }
    public function user()   { return $this->belongsTo(User::class); }

    public function parentAgent() { return $this->belongsTo(Agent::class, 'parent_agent_id'); }
    public function subAgents()   { return $this->hasMany(Agent::class, 'parent_agent_id'); }

    public function students()    { return $this->hasMany(Student::class); }
    public function commissions() { return $this->hasMany(AgentCommission::class); }

    public function masterTransactions() { return $this->hasMany(CommissionTransaction::class, 'master_agent_id'); }
    public function subTransactions()    { return $this->hasMany(CommissionTransaction::class, 'sub_agent_id'); }
}