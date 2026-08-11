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
        Schema::create('student_application_additional_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_application_id');
            $table->string('cost_name');
            $table->decimal('amount', 10, 2);
            $table->decimal('bank_fee', 10, 2)->default(0.00);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->boolean('is_invoiced')->default(false);

            $table->string('payment_approval_status')->default('pending');
            $table->string('payment_attachment')->nullable();
            $table->text('approval_note')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('note')->nullable();

            $table->timestamps();

            $table->foreign('student_application_id', 'sa_add_costs_app_id_foreign')
                  ->references('id')
                  ->on('student_applications')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_application_additional_costs');
    }
};
