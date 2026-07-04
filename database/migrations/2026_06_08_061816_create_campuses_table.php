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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            $table->string('campus_code', 20)->unique()->comment('e.g., UGBSLC1, UKBDLC2, USNYLC3');
            $table->string('name');
            $table->boolean('is_main_campus')->default(0);
            $table->unsignedInteger('campus_number')->nullable()->default(1);
            $table->string('country', 100);
            $table->string('city', 100);
            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('currency', 10)->default('GBP')->comment('GBP, BDT, USD');
            $table->string('timezone', 50)->default('Europe/London');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('campus_code');
            $table->index('status');
            $table->index('country');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
