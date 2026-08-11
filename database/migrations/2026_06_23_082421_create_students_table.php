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
            $table->string('profile_picture')->nullable();
            $table->date('dob')->nullable();
            $table->string('nationality')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries')->nullOnDelete();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->boolean('has_whatsapp')->default(false);
            $table->string('password')->nullable();
            $table->enum('status', [
                'incomplete', 'submitted', 'in_progress', 'pending', 
                'rejected', 'accepted', 'waiting_for_document', 'waiting_for_approval',
                'waiting_for_decision', 'waiting_for_payment', 'waiting_for_offer_letter'
            ])->default('incomplete');
            $table->string('enrolment_status')->nullable();
            $table->timestamp('terminated_at')->nullable();
            $table->text('termination_reason')->nullable();

            $table->string('skype_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('native_language')->nullable();
            $table->string('name_in_passport')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_issue_location')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_state')->nullable();
            $table->string('permanent_postcode')->nullable();
            $table->string('permanent_country')->nullable();
            $table->text('current_address')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_state')->nullable();
            $table->string('current_postcode')->nullable();
            $table->string('current_country')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_mobile')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->boolean('applied_leave_to_remain_uk')->default(false);
            $table->boolean('need_visa_for_uk')->default(false);
            $table->boolean('refused_visa_or_deported')->default(false);
            $table->string('taken_tb_test')->nullable();
            $table->text('bank_balance_info')->nullable();
            $table->foreignId('institute_id')->nullable()->constrained('institutes')->nullOnDelete();
            $table->json('travel_history')->nullable();
            $table->json('immigration_history')->nullable();
            $table->json('visa_refusals')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};