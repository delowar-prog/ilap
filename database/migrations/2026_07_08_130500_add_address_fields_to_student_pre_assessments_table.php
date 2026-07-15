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
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('student_id');
            $table->string('contact_number')->nullable()->after('full_name');
            $table->text('contact_address')->nullable()->after('contact_number');
            $table->string('city')->nullable()->after('contact_address');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->nullable()->after('postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'contact_number', 'contact_address', 'city', 'state', 'postal_code', 'country']);
        });
    }
};
