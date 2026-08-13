<?php

namespace Database\Seeders;

use App\Models\DropdownOption;
use Illuminate\Database\Seeder;

class DropdownOptionSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'study_destination' => [
                'United Kingdom (UK)',
                'United States (USA)',
                'Canada',
                'Australia',
                'New Zealand',
                'Republic of Ireland',
                'Other',
            ],
            'study_method' => [
                'Full-time (On Campus)',
                'Part-time (On Campus)',
                'Online / Distance Learning',
                'Blended (Online + On Campus)',
            ],
            'level_of_study' => [
                'Foundation / Access',
                'Higher National Certificate (HNC)',
                'Higher National Diploma (HND)',
                "Bachelor's Degree (Undergraduate)",
                'Postgraduate Certificate',
                "Master's Degree",
                'PhD / Doctorate',
                'Short Course / Professional Training',
            ],
            'highest_qualification' => [
                'GCSE / O-Level',
                'A-Level / Higher Secondary',
                'Foundation / Access Course',
                'Higher National Diploma (HND)',
                "Bachelor's Degree",
                "Master's Degree",
                'PhD / Doctorate',
                'Professional Qualification',
            ],
            'financial_source' => [
                'Self-funded (Personal Savings)',
                'Family / Sponsor',
                'Bank Loan',
                'Government / Public Funding',
                'Scholarship',
                'Employer Sponsorship',
                'Combination of the above',
            ],
            'english_proficiency' => [
                'English is my native language',
                'IELTS',
                'TOEFL',
                'PTE Academic',
                'Duolingo English Test',
                'Other English Qualification',
                'No English qualification yet',
            ],
            'department' => [
                'CES',
                'GCL',
                'UKVAS',
                'EVENT',
                'MEMBERSHIP',
            ],
            'document_type' => [
                'CV / Resume',
                'Passport',
                'Academic Certificate',
                'Academic Transcript',
                'English Test Result',
                'Statement of Purpose (SOP)',
                'Letter of Reference (LOR)',
                'Other',
            ],
            'letter_type' => [
                'Offer Letter',
                'Acceptance Letter',
                'No Objection Certificate (NOC)',
                'Visa Support Letter',
                'Recommendation Letter',
                'Experience Certificate',
                'Custom Letter',
            ],
            'invoice_type' => [
                'Tuition Fee Invoice',
                'Admission Fee Invoice',
                'Registration Fee Invoice',
                'Course Fee Invoice',
                'Service Charge Invoice',
                'Commission Invoice',
                'General Invoice',
            ],
        ];

        foreach ($defaults as $category => $labels) {
            foreach ($labels as $i => $label) {
                DropdownOption::firstOrCreate(
                    ['category' => $category, 'label' => $label],
                    ['sort_order' => $i, 'is_active' => true]
                );
            }
        }
    }
}
