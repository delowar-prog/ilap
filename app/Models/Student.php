<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'campus_id', 'user_id', 'agent_id', 'student_id', 'promo_code', 'title',
        'first_name', 'middle_name', 'surname', 'dob', 'nationality', 'country_id', 'email',
        'phone', 'password', 'status', 'institute_id',
        // New profile fields
        'profile_picture', 'skype_id', 'gender', 'country_of_birth', 'native_language',
        'name_in_passport', 'passport_number', 'passport_issue_location', 'passport_issue_date', 'passport_expiry_date',
        'permanent_address', 'permanent_city', 'permanent_postcode', 'permanent_country',
        'current_address', 'current_city', 'current_postcode', 'current_country',
        'emergency_contact_name', 'emergency_contact_mobile', 'emergency_contact_email', 'emergency_contact_relationship',
        'applied_leave_to_remain_uk', 'need_visa_for_uk', 'refused_visa_or_deported',
        'taken_tb_test', 'bank_balance_info', 'enrolment_status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dob'                      => 'date',
        'passport_issue_date'      => 'date',
        'passport_expiry_date'     => 'date',
        'applied_leave_to_remain_uk' => 'boolean',
        'need_visa_for_uk'         => 'boolean',
        'refused_visa_or_deported' => 'boolean',
    ];

    public function campus()       { return $this->belongsTo(Campus::class); }
    public function user()         { return $this->belongsTo(User::class); }
    public function agent()        { return $this->belongsTo(Agent::class); }
    public function country()      { return $this->belongsTo(Country::class); }
    public function institute()    { return $this->belongsTo(Institute::class); }

    public function preAssessment()  { return $this->hasOne(StudentPreAssessment::class); }
    public function applications()   { return $this->hasMany(StudentApplication::class); }
    public function academics()      { return $this->hasMany(StudentAcademic::class); }
    public function englishTests()   { return $this->hasMany(StudentEnglishTest::class); }
    public function referees()       { return $this->hasMany(StudentReferee::class); }
    public function documents()      { return $this->hasMany(StudentDocument::class); }
}