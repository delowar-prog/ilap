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
        Schema::table('dropdown_options', function (Blueprint $table) {
            if (!Schema::hasColumn('dropdown_options', 'image_path')) {
                $table->string('image_path')->nullable()->after('website');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dropdown_options', function (Blueprint $table) {
            if (Schema::hasColumn('dropdown_options', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
};
