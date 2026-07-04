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

#[Fillable(['user_first_name', 'user_middle_name', 'user_last_name', 'email', 'password', 'campus_id', 'phone', 'photo'])]
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

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }


    /**
     * কে কে Impersonate (Login As) করতে পারবে তা নির্ধারণ করে।
     */
    public function canImpersonate()
    {
        // ধরে নিচ্ছি আপনার users টেবিলে 'role' নামে একটি কলাম আছে।
        // Super Admin এবং HQ Admin উভয়কেই অনুমতি দেওয়া হলো।
        return $this->hasAnyRole(['Super Admin', 'HQ Admin']);
        
        /* 
         * নোট: আপনি যদি Spatie Laravel Permission প্যাকেজ ব্যবহার করেন, 
         * তবে লজিকটি এমন হবে:
         * return $this->hasAnyRole(['Super Admin', 'HQ Admin']);
         */
    }

    /**
     * কাকে Impersonate করা যাবে না (সিকিউরিটির জন্য)।
     */
    public function canBeImpersonated()
    {
        // Super Admin এবং HQ Admin কে অন্য কেউ impersonate করতে পারবে না।
        // এটি একটি ক্রিটিকাল সিকিউরিটি প্র্যাকটিস।
        return ! $this->hasAnyRole(['Super Admin', 'HQ Admin']);
    }
}
