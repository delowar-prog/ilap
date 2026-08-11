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
        Schema::table('letter_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('letter_templates', 'letter_head_id')) {
                $table->unsignedBigInteger('letter_head_id')->nullable()->after('type');
            }
        });

        Schema::table('invoice_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('invoice_templates', 'letter_head_id')) {
                $table->unsignedBigInteger('letter_head_id')->nullable()->after('type');
            }
        });

        Schema::table('generated_letters', function (Blueprint $table) {
            if (!Schema::hasColumn('generated_letters', 'letter_head_id')) {
                $table->unsignedBigInteger('letter_head_id')->nullable()->after('letter_template_id');
            }
        });

        Schema::table('generated_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('generated_invoices', 'letter_head_id')) {
                $table->unsignedBigInteger('letter_head_id')->nullable()->after('invoice_template_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('letter_templates', function (Blueprint $table) {
            if (Schema::hasColumn('letter_templates', 'letter_head_id')) {
                $table->dropColumn('letter_head_id');
            }
        });

        Schema::table('invoice_templates', function (Blueprint $table) {
            if (Schema::hasColumn('invoice_templates', 'letter_head_id')) {
                $table->dropColumn('letter_head_id');
            }
        });

        Schema::table('generated_letters', function (Blueprint $table) {
            if (Schema::hasColumn('generated_letters', 'letter_head_id')) {
                $table->dropColumn('letter_head_id');
            }
        });

        Schema::table('generated_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('generated_invoices', 'letter_head_id')) {
                $table->dropColumn('letter_head_id');
            }
        });
    }
};
