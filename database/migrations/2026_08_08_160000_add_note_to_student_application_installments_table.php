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
        Schema::table('student_application_installments', function (Blueprint $table) {
            if (!Schema::hasColumn('student_application_installments', 'note')) {
                $table->string('note', 500)->nullable()->after('due_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_installments', function (Blueprint $table) {
            if (Schema::hasColumn('student_application_installments', 'note')) {
                $table->dropColumn('note');
            }
        });
    }
};
