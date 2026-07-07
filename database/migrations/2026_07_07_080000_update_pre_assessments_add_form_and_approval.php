<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            // Academic fields (some already exist with different names, add missing ones)
            $table->string('second_qualification')->nullable();
            $table->string('second_qual_grade')->nullable();
            $table->string('english_proficiency')->nullable();  // Native/IELTS/TOEFL/PTE/Duolingo/Other/None
            $table->text('english_test_details')->nullable();

            // Study plan
            $table->string('study_destination')->nullable();   // UK/USA/Canada/Australia/Other
            $table->string('course_link')->nullable();
            $table->string('financial_source')->nullable();

            // ─── Approval Workflow ───
            $table->enum('assessment_status', ['not_submitted', 'pending', 'approved', 'rejected'])->default('not_submitted');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_note')->nullable();

            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'second_qualification', 'second_qual_grade',
                'english_proficiency', 'english_test_details',
                'study_destination', 'course_link', 'financial_source',
                'assessment_status', 'approved_by', 'approved_at', 'rejection_note',
            ]);
        });
    }
};
