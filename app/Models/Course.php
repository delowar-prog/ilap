<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;
   protected $fillable = [
        // Ownership
        'is_ilap_course',
        
        // Partner Info (for external courses)
        'partner_institute',
        'institute_country',
        'institute_website',
        
        // Course Details
        'course_code',
        'name',
        'description',
        'category',
        'level',
        'subject_area',
        
        // Duration & Mode
        'duration',
        'duration_months',
        'study_method',
        
        // Fees
        'fee',
        'currency',
        'application_fee',
        
        // Additional Details
        'thumbnail',
        'application_deadline',
        'start_date',
        'end_date',
        
        // Intake
        'intake',
        
        // Requirements
        'entry_requirements',
        'english_test',
        'english_test_score',
        
        // Visibility
        'is_featured',
        'is_available_for_admission',
        
        // Media
        'thumbnail',
        'brochure_path',
        
        // Status
        'status',
        'sort_order',
    ];

    protected $casts = [
        'is_ilap_course' => 'boolean',
        'fee' => 'decimal:2',
        'application_fee' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_available_for_admission' => 'boolean',
        'duration_months' => 'integer',
        'sort_order' => 'integer',
        'application_deadline' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // 🔗 Relationships
    public function applications()
    {
        return $this->hasMany(StudentApplication::class);
    }

    public function commissionRules()
    {
        return $this->hasMany(CommissionRule::class);
    }

    public function modules()
    {
        return $this->hasMany(CourseModule::class)->orderBy('priority', 'asc');
    }

    public function brochures()
    {
        return $this->hasMany(CourseBrochure::class);
    }

    // 🎯 Scopes
    public function scopeIlapOwn($query)
    {
        return $query->where('is_ilap_course', true);
    }

    public function scopeExternal($query)
    {
        return $query->where('is_ilap_course', false);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAvailableForAdmission($query)
    {
        return $query->where('is_available_for_admission', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // 🏷️ Accessors
    public function getTypeLabelAttribute(): string
    {
        return $this->is_ilap_course ? 'iLAP Own Course' : 'External Course';
    }

    public function getFullInstituteNameAttribute(): string
    {
        if ($this->is_ilap_course) {
            return 'iLAP Institute';
        }
        return $this->partner_institute ?? 'Unknown Institute';
    }

    public function getFormattedFeeAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->fee, 2);
    }
}