<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_pre_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('current_address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();

            // Academic Background
            $table->string('highest_qualification')->nullable();
            $table->string('name_of_institution')->nullable();
            $table->string('year_of_passing')->nullable();
            $table->string('grades_gpa')->nullable();
            $table->string('field_of_study')->nullable();

            $table->string('second_qualification')->nullable();
            $table->string('second_institution')->nullable();
            $table->string('second_year_of_passing')->nullable();
            $table->string('second_qual_grade')->nullable();
            $table->json('additional_qualifications')->nullable();
            
            // English Proficiency
            $table->string('english_proficiency')->nullable();
            $table->string('english_test')->nullable();
            $table->string('english_score')->nullable();
            $table->text('english_test_details')->nullable();
            $table->string('native_language')->nullable();
            
            // Course Preferences & Study Details
            $table->string('study_destination')->nullable();
            $table->string('intended_course')->nullable();
            $table->string('preferred_course')->nullable();
            $table->string('preferred_university')->nullable();
            $table->string('course_link')->nullable();
            $table->string('preferred_course_2')->nullable();
            $table->string('preferred_university_2')->nullable();
            $table->string('course_link_2')->nullable();
            $table->string('preferred_course_3')->nullable();
            $table->string('preferred_university_3')->nullable();
            $table->string('course_link_3')->nullable();
            $table->string('level_of_study')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('study_method')->nullable();
            $table->string('country_of_choice')->nullable();
            $table->text('purpose_of_study')->nullable();
            $table->date('intake_date')->nullable();
            $table->string('preferred_intake')->nullable();
            
            // Financial & Work Experience
            $table->string('source_of_funding')->nullable();
            $table->string('financial_source')->nullable();
            $table->text('work_experience')->nullable();
            $table->text('visa_refusal_history')->nullable();
            $table->text('previous_uk_study_history')->nullable();
            
            // Documents
            $table->string('cv_path')->nullable();
            $table->string('selected_form')->nullable();
            $table->json('mandatory_documents')->nullable();

            // Assessment Approval
            $table->enum('assessment_status', ['not_submitted', 'pending', 'approved', 'rejected'])->default('not_submitted');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_note')->nullable();

            $table->json('travel_history')->nullable();
            $table->json('immigration_history')->nullable();
            $table->json('visa_refusals')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_pre_assessments');
    }
};