<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['user_first_name', 'user_middle_name', 'user_last_name', 'email', 'password', 'campus_id', 'phone', 'photo', 'signature', 'referral_code'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable, Impersonate; 

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Virtual "name" attribute — combines first + last name.
     * Allows ->name to work everywhere in views/controllers.
     */
    public function getNameAttribute(): string
    {
        return trim(($this->user_first_name ?? '') . ' ' . ($this->user_last_name ?? ''));
    }

    /**
     * One-to-one: User -> Student profile
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }



    /**
     * Determine who can impersonate other users
     */
    public function canImpersonate(): bool
    {
        // Only Super Admin and HQ Admin can impersonate
        return $this->hasAnyRole(['Super Admin', 'HQ Admin']);
    }

    /**
     * Determine who can be impersonated
     */
    public function canBeImpersonated(): bool
    {
        // Prevent Super Admin and HQ Admin from being impersonated
        return ! $this->hasAnyRole(['Super Admin', 'HQ Admin']);
    }
}
