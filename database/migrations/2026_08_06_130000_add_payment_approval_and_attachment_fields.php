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
            if (!Schema::hasColumn('student_application_installments', 'attachment')) {
                $table->string('attachment')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('student_application_installments', 'pending_paid_amount')) {
                $table->decimal('pending_paid_amount', 10, 2)->nullable()->after('attachment');
            }
            if (!Schema::hasColumn('student_application_installments', 'approval_status')) {
                $table->string('approval_status')->default('none')->after('pending_paid_amount');
            }
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            if (!Schema::hasColumn('student_application_additional_costs', 'attachment')) {
                $table->string('attachment')->nullable()->after('transaction_id');
            }
            if (!Schema::hasColumn('student_application_additional_costs', 'approval_status')) {
                $table->string('approval_status')->default('none')->after('attachment');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_installments', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'pending_paid_amount', 'approval_status']);
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->dropColumn(['attachment', 'approval_status']);
        });
    }
};
