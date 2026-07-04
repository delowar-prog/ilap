<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('commission_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('student_applications')->cascadeOnDelete();
            $table->foreignId('master_agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('sub_agent_id')->nullable()->constrained('agents')->nullOnDelete();
            
            $table->decimal('total_commission', 10, 2);
            $table->decimal('master_commission', 10, 2);
            $table->decimal('sub_commission', 10, 2)->default(0);
            $table->string('currency', 10);
            
            // Status: Decision Pending, Payment Due, Paid to master Agent, Paid to sub-agent
            $table->enum('status', [
                'decision_pending', 'payment_due', 
                'paid_to_master', 'paid_to_sub', 'fully_paid'
            ])->default('decision_pending');
            
            // Master Agent Payment Details
            $table->date('master_paid_date')->nullable();
            $table->string('master_receipt_path')->nullable();
            
            // Sub Agent Payment Details
            $table->date('sub_paid_date')->nullable();
            $table->string('sub_receipt_path')->nullable();
            
            $table->text('hq_notes')->nullable(); // HQ staff can override/amend
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commission_transactions');
    }
};
