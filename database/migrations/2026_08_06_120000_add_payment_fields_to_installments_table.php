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
            if (!Schema::hasColumn('student_application_installments', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('paid_amount');
            }
            if (!Schema::hasColumn('student_application_installments', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('paid_at');
            }
            if (!Schema::hasColumn('student_application_installments', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_method');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_installments', function (Blueprint $table) {
            $table->dropColumn(['paid_at', 'payment_method', 'transaction_id']);
        });
    }
};
