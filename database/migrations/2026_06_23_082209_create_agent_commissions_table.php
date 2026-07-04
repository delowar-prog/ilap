<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('agent_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('agents')->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete(); // Null হলে সব কোর্সের জন্য প্রযোজ্য
            $table->enum('commission_type', ['flat', 'percentage']);
            $table->decimal('amount', 10, 2); 
            $table->string('currency', 10)->default('USD'); // GBP, USD, BDT, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agent_commissions');
    }
};