<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('agent_id')->nullable()->constrained('agents')->nullOnDelete();
            $table->string('student_id')->unique(); 
            $table->string('promo_code')->nullable(); 
            $table->string('title', 10)->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('surname');
            $table->date('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password')->nullable(); // For direct website signup
            $table->enum('status', [
                'incomplete', 'submitted', 'in_progress', 'pending', 
                'rejected', 'accepted', 'waiting_for_document', 'waiting_for_approval',
                'waiting_for_decision', 'waiting_for_payment', 'waiting_for_offer_letter'
            ])->default('incomplete');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};