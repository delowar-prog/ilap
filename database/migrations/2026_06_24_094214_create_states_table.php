<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->constrained('countries')->cascadeOnDelete();
            $table->string('name', 100);
            $table->string('state_code', 10)->nullable();
            $table->string('type', 50)->nullable(); // Division, State, Province, District
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->index(['country_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};