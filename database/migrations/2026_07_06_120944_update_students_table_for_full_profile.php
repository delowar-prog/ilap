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
        Schema::table('students', function (Blueprint $table) {
            $table->string('skype_id')->nullable();
            $table->string('gender')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('native_language')->nullable();

            // Passport Details
            $table->string('name_in_passport')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('passport_issue_location')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->date('passport_expiry_date')->nullable();

            // Addresses
            $table->text('permanent_address')->nullable();
            $table->string('permanent_city')->nullable();
            $table->string('permanent_postcode')->nullable();
            $table->string('permanent_country')->nullable();
            
            $table->text('current_address')->nullable();
            $table->string('current_city')->nullable();
            $table->string('current_postcode')->nullable();
            $table->string('current_country')->nullable();

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_mobile')->nullable();
            $table->string('emergency_contact_email')->nullable();
            $table->string('emergency_contact_relationship')->nullable();

            // Travel History & Immigration
            $table->boolean('applied_leave_to_remain_uk')->default(false);
            $table->boolean('need_visa_for_uk')->default(false);
            $table->boolean('refused_visa_or_deported')->default(false);

            // Additional Info
            $table->string('taken_tb_test')->nullable();
            $table->text('bank_balance_info')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'skype_id', 'gender', 'country_of_birth', 'native_language',
                'name_in_passport', 'passport_number', 'passport_issue_location', 'passport_issue_date', 'passport_expiry_date',
                'permanent_address', 'permanent_city', 'permanent_postcode', 'permanent_country',
                'current_address', 'current_city', 'current_postcode', 'current_country',
                'emergency_contact_name', 'emergency_contact_mobile', 'emergency_contact_email', 'emergency_contact_relationship',
                'applied_leave_to_remain_uk', 'need_visa_for_uk', 'refused_visa_or_deported',
                'taken_tb_test', 'bank_balance_info'
            ]);
        });
    }
};
