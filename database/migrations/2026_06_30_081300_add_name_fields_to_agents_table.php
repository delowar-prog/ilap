<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            // Add split name fields after 'name'
            $table->string('first_name', 100)->nullable()->after('name');
            $table->string('middle_name', 100)->nullable()->after('first_name');
            $table->string('last_name', 100)->nullable()->after('middle_name');
            // Add phone_code for international dialling prefix
            $table->string('phone_code', 10)->nullable()->after('phone')
                ->comment('+880, +44, +1');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'middle_name', 'last_name', 'phone_code']);
        });
    }
};
