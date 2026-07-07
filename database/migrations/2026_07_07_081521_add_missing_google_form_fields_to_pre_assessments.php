<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->date('dob')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('name_of_institution')->nullable();
            $table->string('year_of_passing')->nullable();
            $table->string('second_institution')->nullable();
            $table->string('second_year_of_passing')->nullable();
            $table->text('work_experience')->nullable();
            $table->string('preferred_intake')->nullable();
            $table->text('visa_refusal_history')->nullable();
            $table->text('previous_uk_study_history')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropColumn([
                'dob',
                'passport_number',
                'name_of_institution',
                'year_of_passing',
                'second_institution',
                'second_year_of_passing',
                'work_experience',
                'preferred_intake',
                'visa_refusal_history',
                'previous_uk_study_history',
            ]);
        });
    }
};
