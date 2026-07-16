<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_academics', function (Blueprint $table) {
            $table->string('result_type')->nullable()->after('award_date');
            $table->string('other_result_type')->nullable()->after('result_type');
        });
    }

    public function down(): void
    {
        Schema::table('student_academics', function (Blueprint $table) {
            $table->dropColumn(['result_type', 'other_result_type']);
        });
    }
};
