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
        'permanent_address', 'permanent_city', 'permanent_state', 'permanent_postcode', 'permanent_country',
        'current_address', 'current_city', 'current_state', 'current_postcode', 'current_country',
        'emergency_contact_name', 'emergency_contact_mobile', 'emergency_contact_email', 'emergency_contact_relationship',
        'applied_leave_to_remain_uk', 'need_visa_for_uk', 'refused_visa_or_deported',
        'taken_tb_test', 'bank_balance_info', 'enrolment_status',
        // Travel & Immigration
        'travel_history', 'immigration_history', 'visa_refusals',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dob' => 'date',
        'passport_issue_date' => 'date',
        'passport_expiry_date' => 'date',
        'applied_leave_to_remain_uk' => 'boolean',
        'need_visa_for_uk' => 'boolean',
        'refused_visa_or_deported' => 'boolean',
        'travel_history' => 'array',
        'immigration_history' => 'array',
        'visa_refusals' => 'array',
    ];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

    public function preAssessment()
    {
        return $this->hasOne(StudentPreAssessment::class);
    }

    public function applications()
    {
        return $this->hasMany(StudentApplication::class);
    }

    public function academics()
    {
        return $this->hasMany(StudentAcademic::class);
    }

    public function englishTests()
    {
        return $this->hasMany(StudentEnglishTest::class);
    }

    public function referees()
    {
        return $this->hasMany(StudentReferee::class);
    }

    public function documents()
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function getCompletionPercentage()
    {
        $completionPercent = 0;

        // 1. Personal Fields (5 fields) -> Max 35%
        $personalFields = ['first_name', 'surname', 'dob', 'nationality', 'phone'];
        $filledPersonal = 0;
        foreach ($personalFields as $f) {
            if (! empty($this->$f)) {
                $filledPersonal++;
            }
        }
        $completionPercent += ($filledPersonal / count($personalFields)) * 35;

        // 2. Permanent Address (5 fields) -> Max 35%
        $addressFields = ['permanent_address', 'permanent_postcode', 'permanent_state', 'permanent_city', 'permanent_country'];
        $filledAddress = 0;
        foreach ($addressFields as $f) {
            if (! empty($this->$f)) {
                $filledAddress++;
            }
        }
        $completionPercent += ($filledAddress / count($addressFields)) * 35;

        // 3. Travel & Immigration (3 sections) -> Max 20%
        $travelScore = 0;

        // Travel history section (7%)
        $travel = $this->travel_history;
        if (! empty($travel) && is_array($travel)) {
            $hasHistory = $travel['has_history'] ?? '';
            if ($hasHistory === 'no') {
                $travelScore += 7;
            } elseif ($hasHistory === 'yes') {
                $reqs = ['arrival_date', 'departure_date', 'visa_start_date', 'visa_expiry_date', 'purpose_of_visit', 'country', 'visa_type'];
                $valid = true;
                foreach ($reqs as $r) {
                    if (empty($travel[$r])) {
                        $valid = false;
                        break;
                    }
                }
                if ($valid) {
                    $travelScore += 7;
                }
            }
        }

        // Immigration history section (6%)
        $imm = $this->immigration_history;
        if (! empty($imm) && is_array($imm) && ! empty($imm['countries'])) {
            $travelScore += 6;
        }

        // Visa refusals section (7%)
        $refusal = $this->visa_refusals;
        if (! empty($refusal) && is_array($refusal)) {
            $hasRefusal = $refusal['has_refusal'] ?? '';
            if ($hasRefusal === 'no') {
                $travelScore += 7;
            } elseif ($hasRefusal === 'yes') {
                $reqs = ['refusal_type', 'refusal_date', 'country', 'visa_type', 'details'];
                $valid = true;
                foreach ($reqs as $r) {
                    if (empty($refusal[$r])) {
                        $valid = false;
                        break;
                    }
                }
                if ($valid) {
                    $travelScore += 7;
                }
            }
        }
        $completionPercent += $travelScore;

        // 4. Mandatory Documents (10%)
        $preAssessment = $this->preAssessment;
        $mandatoryDocs = ($preAssessment && $preAssessment->mandatory_documents) ? $preAssessment->mandatory_documents : [];

        $requiredTypes = [];
        if (is_array($mandatoryDocs)) {
            foreach ($mandatoryDocs as $docType => $status) {
                if (is_numeric($docType)) {
                    $requiredTypes[] = $status;
                } elseif ($status === 'M') {
                    $requiredTypes[] = $docType;
                }
            }
        }

        if (empty($requiredTypes)) {
            $completionPercent += 10;
        } else {
            $uploadedTypes = $this->documents()
                ->where('uploaded_by', 'student')
                ->pluck('document_type')
                ->toArray();

            $allUploaded = true;
            foreach ($requiredTypes as $docType) {
                if (! in_array($docType, $uploadedTypes)) {
                    $allUploaded = false;
                    break;
                }
            }
            if ($allUploaded) {
                $completionPercent += 10;
            }
        }

        return min(round($completionPercent), 100);
    }
}
