<?php

namespace App\Models;

use App\BelongsToBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'campuses';

    protected $fillable = [
        'campus_type',
        'campus_code',
        'name',
        'is_main_campus',
        'country',
        'city',
        'address',
        'phone',
        'email',
        'website_link',
        'note',
        'logo',
        'currency',
        'timezone',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'string',
    ];

    /**
     * Scope: Active branches only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Relationship: Branch has many Users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'campus_id');
    }

    /**
     * Relationship: Campus has many Students
     */
    public function students()
    {
        return $this->hasMany(User::class, 'campus_id')->where('role', 'student');
    }


    /**
     * Get formatted branch info (Code - Name)
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->campus_code} - {$this->name}";
    }

    /**
     * Get currency symbol
     */
    public function getCurrencySymbolAttribute(): string
    {
        return match($this->currency) {
            'GBP' => '£',
            'BDT' => '৳',
            'USD' => '$',
            'EUR' => '€',
            default => $this->currency,
        };
    }

    // Auto-generate code has been removed based on user request
}

