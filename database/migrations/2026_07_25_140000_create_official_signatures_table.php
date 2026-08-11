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
        Schema::create('official_signatures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation')->nullable();
            $table->string('tag_key')->unique(); // e.g. principal_signature -> {{principal_signature}}
            $table->string('signature_path');
            $table->string('seal_path')->nullable();
            $table->string('type')->default('signature'); // signature, seal
            $table->string('status')->default('active'); // active, inactive
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('official_signatures');
    }
};
