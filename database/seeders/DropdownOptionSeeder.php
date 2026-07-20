<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DropdownOption;

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
