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
        Schema::create('generated_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('letter_template_id')->nullable()->constrained('letter_templates')->onDelete('set null');
            $table->unsignedBigInteger('letter_head_id')->nullable();
            $table->string('letter_title');
            $table->string('file_path');
            $table->string('file_type')->default('pdf'); 
            $table->foreignId('generated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('sent_to_student')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generated_letters');
    }
};
