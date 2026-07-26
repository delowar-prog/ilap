<?php

namespace Database\Seeders;

use App\Models\LetterTemplate;
use Illuminate\Database\Seeder;

class LetterTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'title'        => 'Official Offer Letter',
                'type'         => 'offer',
                'subject'      => 'CONDITIONAL OFFER OF ADMISSION',
                'content_body' => "To,\nName: {{student_name}}\nStudent ID: {{student_id}}\nPassport No: {{passport_number}}\nEmail: {{email}}\n\nDear {{student_name}},\n\nWe are pleased to inform you that your application for admission has been conditionally accepted at {{institute_name}} for the course: {{course_name}}.\n\nThis offer is subject to the verification of your original documents, academic transcripts, and compliance with institutional requirements.\n\nPlease confirm your acceptance by signing and returning this letter along with the required deposit payment on or before {{today_date}}.\n\nWe look forward to welcoming you to {{institute_name}}.\n\nSincerely,\nAdmissions Office\n{{institute_name}}",
                'status'       => true,
            ],
            [
                'title'        => 'No Objection Certificate (NOC)',
                'type'         => 'noc',
                'subject'      => 'NO OBJECTION CERTIFICATE (NOC)',
                'content_body' => "TO WHOM IT MAY CONCERN\n\nThis is to certify that {{student_name}}, holding Student ID {{student_id}} and Passport Number {{passport_number}}, is a registered student at {{institute_name}} pursuing {{course_name}}.\n\nThe institute has NO OBJECTION to {{student_name}} applying for visa processing, travel, or academic training during the course tenure.\n\nThis certificate is issued upon the request of the student for official purposes.\n\nIssued on: {{today_date}}\n\nAuthorized Signature,\nRegistrar Office\n{{institute_name}}",
                'status'       => true,
            ],
            [
                'title'        => 'Visa Support Recommendation Letter',
                'type'         => 'visa',
                'subject'      => 'RECOMMENDATION LETTER FOR STUDENT VISA APPLICATION',
                'content_body' => "To,\nThe Visa Officer,\nEmbassy / High Commission\n\nSubject: Visa Recommendation for {{student_name}} (Passport: {{passport_number}})\n\nRespected Sir/Madam,\n\nWe write to confirm that {{student_name}} (Student ID: {{student_id}}) has been officially enrolled at {{institute_name}} for the upcoming academic program: {{course_name}}.\n\nThe student has fulfilled all initial entry requirements. We kindly request you to grant the necessary student visa to enable {{student_name}} to pursue their studies in a timely manner.\n\nIf you require any further information, please feel free to contact us.\n\nYours faithfully,\nInternational Student Office\n{{institute_name}}",
                'status'       => true,
            ],
        ];

        foreach ($templates as $data) {
            LetterTemplate::firstOrCreate(
                ['title' => $data['title']],
                $data
            );
        }
    }
}
