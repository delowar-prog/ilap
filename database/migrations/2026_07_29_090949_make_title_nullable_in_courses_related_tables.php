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
        Schema::table('course_modules', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
        Schema::table('course_brochures', function (Blueprint $table) {
            $table->string('title')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_modules', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
        Schema::table('course_brochures', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
        });
    }
};
