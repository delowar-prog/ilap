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
            $table->json('travel_history')->nullable();
            $table->json('immigration_history')->nullable();
            $table->json('visa_refusals')->nullable();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->json('travel_history')->nullable();
            $table->json('immigration_history')->nullable();
            $table->json('visa_refusals')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropColumn(['travel_history', 'immigration_history', 'visa_refusals']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['travel_history', 'immigration_history', 'visa_refusals']);
        });
    }
};
