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
            if (!Schema::hasColumn('student_application_installments', 'bank_fee')) {
                $table->decimal('bank_fee', 10, 2)->default(0.00)->after('amount');
            }
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            if (!Schema::hasColumn('student_application_additional_costs', 'bank_fee')) {
                $table->decimal('bank_fee', 10, 2)->default(0.00)->after('amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_installments', function (Blueprint $table) {
            if (Schema::hasColumn('student_application_installments', 'bank_fee')) {
                $table->dropColumn('bank_fee');
            }
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            if (Schema::hasColumn('student_application_additional_costs', 'bank_fee')) {
                $table->dropColumn('bank_fee');
            }
        });
    }
};
