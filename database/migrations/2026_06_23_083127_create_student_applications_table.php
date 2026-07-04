<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('assigned_agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->enum('stage', [
                'incomplete', 'submitted', 'accepted', 'rejected',
                'offer_letter_generated', 'documents_uploaded', 'invoice_generated',
                'payment_made', 'enrolment_confirmed'
            ])->default('incomplete');
            $table->decimal('total_fee', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};