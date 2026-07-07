<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_academics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('education_level'); // 10th, 12th, Bachelor, Master, Research
            $table->string('country')->nullable();
            $table->string('institution_name')->nullable();
            $table->text('institution_address')->nullable();
            $table->string('course_name')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('award_date')->nullable();
            $table->string('result_percentage')->nullable();
            $table->string('gpa')->nullable();
            $table->string('result_out_of')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_academics');
    }
};
