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
        Schema::table('student_documents', function (Blueprint $table) {
            $table->string('uploaded_by')->default('student')->after('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_documents', function (Blueprint $table) {
            $table->dropColumn('uploaded_by');
        });
    }
};
