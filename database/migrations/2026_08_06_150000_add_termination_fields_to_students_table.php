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
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'terminated_at')) {
                $table->timestamp('terminated_at')->nullable()->after('enrolment_status');
            }
            if (!Schema::hasColumn('students', 'termination_reason')) {
                $table->text('termination_reason')->nullable()->after('terminated_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['terminated_at', 'termination_reason']);
        });
    }
};
