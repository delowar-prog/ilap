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
        Schema::table('official_signatures', function (Blueprint $table) {
            $table->string('signature_path')->nullable()->change();
            $table->string('seal_path')->nullable()->after('signature_path');
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('official_signatures', function (Blueprint $table) {
            $table->string('type')->default('signature');
            $table->dropColumn('seal_path');
        });
    }
};
