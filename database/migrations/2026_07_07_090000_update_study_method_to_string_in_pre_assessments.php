<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            // Change study_method to string so it can accept any value from the form
            $table->string('study_method')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('student_pre_assessments', function (Blueprint $table) {
            // We can't reliably convert it back to enum without potentially truncating data
            // but we can define the down method
            // $table->enum('study_method', ['online', 'on_campus', 'blended'])->nullable()->change();
        });
    }
};
