<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_english_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('test_name')->nullable(); // UKVI-IELTS, TOEFL, etc
            $table->date('date_of_exam')->nullable();
            $table->string('listening')->nullable();
            $table->string('reading')->nullable();
            $table->string('writing')->nullable();
            $table->string('speaking')->nullable();
            $table->string('overall_score')->nullable();
            $table->string('cefr_level')->nullable();
            $table->string('ukvi_number')->nullable();
            $table->string('trf_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_english_tests');
    }
};
