<?php

use Illuminate\Database\Migrations\Migration;

// This migration is intentionally left as a no-op.
// Campus Types are managed via the DropdownOption system (category: 'campus_type').
return new class extends Migration
{
    public function up(): void
    {
        // No action needed – campus types live in dropdown_options table
    }

    public function down(): void
    {
        // No action needed
    }
};
