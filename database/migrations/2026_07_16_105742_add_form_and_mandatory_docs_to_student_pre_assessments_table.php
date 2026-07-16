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
            $table->string('selected_form')->nullable()->after('rejection_note');
            $table->json('mandatory_documents')->nullable()->after('selected_form');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropColumn(['selected_form', 'mandatory_documents']);
        });
    }
};
