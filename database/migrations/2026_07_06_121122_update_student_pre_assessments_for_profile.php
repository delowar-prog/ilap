<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->string('preferred_course_2')->nullable();
            $table->string('preferred_course_3')->nullable();
            $table->string('preferred_university_2')->nullable();
            $table->string('preferred_university_3')->nullable();
            $table->date('intake_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropColumn([
                'preferred_course_2',
                'preferred_course_3',
                'preferred_university_2',
                'preferred_university_3',
                'intake_date',
            ]);
        });
    }
};
