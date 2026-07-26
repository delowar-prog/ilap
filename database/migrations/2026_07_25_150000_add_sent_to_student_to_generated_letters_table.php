<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('generated_letters', function (Blueprint $table) {
            $table->boolean('sent_to_student')->default(false)->after('generated_by');
            $table->timestamp('sent_at')->nullable()->after('sent_to_student');
        });
    }

    public function down(): void
    {
        Schema::table('generated_letters', function (Blueprint $table) {
            $table->dropColumn(['sent_to_student', 'sent_at']);
        });
    }
};
