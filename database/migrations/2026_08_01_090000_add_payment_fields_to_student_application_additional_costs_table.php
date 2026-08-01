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
        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid'])->default('pending')->after('amount');
            $table->decimal('paid_amount', 10, 2)->default(0.00)->after('status');
            $table->timestamp('paid_at')->nullable()->after('paid_amount');
            $table->string('payment_method')->nullable()->after('paid_at');
            $table->string('transaction_id')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->dropColumn(['status', 'paid_amount', 'paid_at', 'payment_method', 'transaction_id']);
        });
    }
};
