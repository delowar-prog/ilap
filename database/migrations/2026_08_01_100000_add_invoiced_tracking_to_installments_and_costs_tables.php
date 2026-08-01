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
            $table->boolean('is_invoiced')->default(false)->after('paid_amount');
            $table->timestamp('invoiced_at')->nullable()->after('is_invoiced');
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->boolean('is_invoiced')->default(false)->after('transaction_id');
            $table->timestamp('invoiced_at')->nullable()->after('is_invoiced');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_installments', function (Blueprint $table) {
            $table->dropColumn(['is_invoiced', 'invoiced_at']);
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->dropColumn(['is_invoiced', 'invoiced_at']);
        });
    }
};
