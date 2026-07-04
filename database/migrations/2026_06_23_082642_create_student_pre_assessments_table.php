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
            
            // Academic Background
            $table->string('highest_qualification')->nullable();
            $table->string('grades_gpa')->nullable();
            $table->string('field_of_study')->nullable();
            
            // English Proficiency
            $table->string('english_test')->nullable(); // IELTS, TOEFL
            $table->string('english_score')->nullable();
            $table->string('native_language')->nullable();
            
            // Course Preferences
            $table->string('intended_course')->nullable();
            $table->string('level_of_study')->nullable(); // Undergraduate, Postgraduate
            $table->string('institute_name')->nullable();
            $table->enum('study_method', ['online', 'on_campus', 'blended'])->nullable();
            $table->string('country_of_choice')->nullable();
            $table->text('purpose_of_study')->nullable();
            
            // Financial
            $table->string('source_of_funding')->nullable(); // self-funded, scholarship, loan
            
            // Documents
            $table->string('cv_path')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_pre_assessments');
    }
};