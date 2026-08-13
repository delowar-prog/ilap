<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dropdown_options', function (Blueprint $table) {
            $table->integer('margin_top')->default(130)->nullable()->after('image_path');
            $table->integer('margin_bottom')->default(120)->nullable()->after('margin_top');
            $table->integer('margin_left')->default(0)->nullable()->after('margin_bottom');
            $table->integer('margin_right')->default(0)->nullable()->after('margin_left');
        });
    }

    public function down(): void
    {
        Schema::table('dropdown_options', function (Blueprint $table) {
            $table->dropColumn(['margin_top', 'margin_bottom', 'margin_left', 'margin_right']);
        });
    }
};
