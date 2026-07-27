<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DropdownOption extends Model
{
    use HasFactory;

    protected $fillable = ['category', 'label', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    // Available categories with their display names
    public static array $categories = [
        'study_destination' => 'Preferred Study Destination',
        'study_method' => 'Preferred Study Method',
        'level_of_study' => 'Level of Study',
        'highest_qualification' => 'Highest Qualification',
        'financial_source' => 'Funding Source',
        'english_proficiency' => 'English Language Proficiency',
        'department' => 'Departments',
        'document_type' => 'Document Types',
        'letter_type' => 'Letter Template Types',
        'invoice_type' => 'Invoice Template Types',
        'campus_type' => 'Campus Types',
    ];

    /**
     * Get active options for a given category, ordered by sort_order then label.
     * Returns a plain array of label strings for use in views.
     */
    public static function active(string $category): array
    {
        return static::where('category', $category)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->pluck('label')
            ->toArray();
    }

    /**
     * Get all options for a given category (including inactive).
     */
    public static function forCategory(string $category)
    {
        return static::where('category', $category)
            ->orderBy('sort_order')
            ->orderBy('label')
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
