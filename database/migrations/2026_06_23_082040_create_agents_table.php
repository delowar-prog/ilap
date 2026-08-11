<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campus_id')->constrained('campuses')->cascadeOnDelete(); // Branch isolation
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // User login account
            $table->foreignId('parent_agent_id')->nullable()->constrained('agents')->nullOnDelete(); // Parent Master Agent ID for sub-agents
            $table->string('agent_code')->unique(); // Unique agent referral code
            $table->enum('agent_type', ['master', 'sub_agent'])->default('master');
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
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