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
        'campus_code',
        'name',
        'is_main_campus',
        'country',
        'city',
        'address',
        'phone',
        'email',
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
     * Relationship: Branch has many Students
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

    /**
     * Boot the model and add creating hook for auto-generating campus code.
     */
    protected static function booted()
    {
        static::creating(function ($campus) {
            if (empty($campus->campus_code)) {
                $campus->campus_code = static::generateCampusCode($campus->country, $campus->name);
            }
        });
    }

    /**
     * Generate unique Campus Code following format: {ISO2}{Abbreviation}C{Sequence}
     */
    public static function generateCampusCode(?string $countryName, ?string $campusName): string
    {
        if (empty($countryName)) {
            $iso2 = 'XX';
        } else {
            $country = Country::where('name', $countryName)->first();
            $iso2 = $country ? strtoupper($country->iso2) : 'XX';
        }

        if (empty($campusName)) {
            $abbr = 'XXX';
        } else {
            // Clean name and split to words
            $cleanName = preg_replace('/[^A-Za-z0-9\s]/', '', $campusName);
            $words = array_values(array_filter(explode(' ', $cleanName)));
            $wordCount = count($words);

            if ($wordCount === 0) {
                $abbr = 'XXX';
            } elseif ($wordCount === 1) {
                $word = strtoupper($words[0]);
                $abbr = substr($word, 0, 3);
            } elseif ($wordCount === 2) {
                $w1 = strtoupper($words[0]);
                $w2 = strtoupper($words[1]);
                $abbr = substr($w1, 0, 1) . substr($w2, 0, 1) . substr($w2, -1);
            } else {
                $abbr = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1) . substr($words[2], 0, 1));
            }
        }

        if (strlen($abbr) < 3) {
            $abbr = str_pad($abbr, 3, 'X');
        }

        $prefix = $iso2 . $abbr . 'C';

        $maxSequence = self::where('campus_code', 'like', $prefix . '%')
            ->get()
            ->map(function ($c) use ($prefix) {
                $numPart = substr($c->campus_code, strlen($prefix));
                return is_numeric($numPart) ? (int)$numPart : 0;
            })
            ->max() ?? 0;

        return $prefix . ($maxSequence + 1);
    }
}

