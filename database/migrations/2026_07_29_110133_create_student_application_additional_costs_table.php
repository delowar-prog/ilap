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
        Schema::create('student_application_additional_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_application_id');
            $table->string('cost_name');
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('student_application_id', 'sa_add_costs_app_id_foreign')
                  ->references('id')
                  ->on('student_applications')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_application_additional_costs');
    }
};
