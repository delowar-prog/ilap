<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('iso2', 2)->unique()->nullable(); // ISO Code (BD, US, GB)
            $table->string('iso3', 3)->unique()->nullable(); // (BGD, USA, GBR)
            $table->string('phone_code', 10)->nullable(); // +880, +1, +44
            $table->string('currency', 10)->nullable(); // BDT, USD, GBP
            $table->string('currency_symbol', 10)->nullable(); // e.g. $, £, BDT
            $table->string('capital', 100)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};