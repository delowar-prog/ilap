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
        if (!Schema::hasTable('student_application_refunds')) {
            Schema::create('student_application_refunds', function (Blueprint $table) {
                $table->id();
                $table->foreignId('application_id')->constrained('student_applications')->onDelete('cascade');
                $table->enum('refund_type', ['installment', 'additional_cost']);
                $table->unsignedBigInteger('item_id');
                $table->decimal('original_paid_amount', 10, 2);
                $table->decimal('deduction_percentage', 5, 2)->nullable();
                $table->decimal('deduction_amount', 10, 2)->default(0.00);
                $table->decimal('refund_amount', 10, 2);
                $table->text('reason_note')->nullable();
                $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamp('refunded_at')->useCurrent();
                $table->timestamps();
            });
        }

        Schema::table('student_application_installments', function (Blueprint $table) {
            if (!Schema::hasColumn('student_application_installments', 'refunded_amount')) {
                $table->decimal('refunded_amount', 10, 2)->default(0.00)->after('paid_amount');
            }
            if (!Schema::hasColumn('student_application_installments', 'deducted_amount')) {
                $table->decimal('deducted_amount', 10, 2)->default(0.00)->after('refunded_amount');
            }
        });

        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            if (!Schema::hasColumn('student_application_additional_costs', 'paid_amount')) {
                $table->decimal('paid_amount', 10, 2)->default(0.00)->after('amount');
            }
            if (!Schema::hasColumn('student_application_additional_costs', 'refunded_amount')) {
                $table->decimal('refunded_amount', 10, 2)->default(0.00)->after('paid_amount');
            }
            if (!Schema::hasColumn('student_application_additional_costs', 'deducted_amount')) {
                $table->decimal('deducted_amount', 10, 2)->default(0.00)->after('refunded_amount');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_application_additional_costs', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'refunded_amount', 'deducted_amount']);
        });

        Schema::table('student_application_installments', function (Blueprint $table) {
            $table->dropColumn(['refunded_amount', 'deducted_amount']);
        });

        Schema::dropIfExists('student_application_refunds');
    }
};
