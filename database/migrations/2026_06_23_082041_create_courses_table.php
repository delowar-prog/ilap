<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            
            // 🎯 Course Ownership (iLAP vs External)
            $table->boolean('is_ilap_course')->default(false)
                ->comment('true = iLAP own course, false = External institute course');
            
            // 🏢 Partner Institute (only for external courses)
            $table->string('partner_institute')->nullable()
                ->comment('University/School name for external courses');
            $table->string('institute_country')->nullable()
                ->comment('Country where institute is located');
            $table->string('institute_website')->nullable();
            
            // 📚 Course Details
            $table->string('course_code', 50)->unique()->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('category', 50)->nullable()
                ->comment('short, long, degree, diploma, certificate');
            $table->string('level', 50)->nullable()
                ->comment('undergraduate, postgraduate, phd, professional');
            $table->string('subject_area')->nullable()
                ->comment('Business, Engineering, IT, Medicine, etc.');
            
            // ⏱️ Duration & Mode
            $table->string('duration')->nullable()
                ->comment('e.g., 1 year, 6 months, 4 years');
            $table->integer('duration_months')->nullable();
            $table->enum('study_method', ['online', 'on_campus', 'blended'])->nullable();
            
            // 💰 Fees
            $table->decimal('fee', 12, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->decimal('application_fee', 10, 2)->nullable();
            
            // 📅 Intake
            $table->string('intake')->nullable()
                ->comment('Fall, Spring, Summer, Rolling');
            $table->date('application_deadline')->nullable();
            
            // 📊 Entry Requirements
            $table->text('entry_requirements')->nullable();
            $table->decimal('ielts_required', 3, 1)->nullable();
            
            // 🌐 Visibility
            $table->boolean('is_featured')->default(false)
                ->comment('Show on homepage/featured section');
            $table->boolean('is_available_for_admission')->default(true);
            
            // 📁 Media
            $table->string('thumbnail')->nullable();
            $table->string('brochure_path')->nullable();
            
            // 🔧 Status
            $table->enum('status', ['active', 'inactive', 'archived'])->default('active');
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['is_ilap_course', 'status']);
            $table->index(['category', 'status']);
            $table->index(['partner_institute', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};