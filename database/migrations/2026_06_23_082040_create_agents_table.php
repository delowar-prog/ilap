<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->cascadeOnDelete(); // ব্রাঞ্চ আইসোলেশনের জন্য
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // লগইন করার জন্য
            $table->foreignId('parent_agent_id')->nullable()->constrained('agents')->nullOnDelete(); // Sub-agent এর জন্য Master Agent ID
            $table->string('agent_code')->unique(); // Promo Code / Referral Code হিসেবে ব্যবহৃত হবে
            $table->enum('agent_type', ['master', 'sub_agent'])->default('master');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('logo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};