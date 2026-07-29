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
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('ielts_required');
            $table->string('english_test')->nullable()->after('entry_requirements');
            $table->string('english_test_score')->nullable()->after('english_test');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->decimal('ielts_required', 3, 1)->nullable()->after('entry_requirements');
            $table->dropColumn(['english_test', 'english_test_score']);
        });
    }
};
