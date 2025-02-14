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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key (AnnouncementID)
            $table->string('department');  // e.g., "CCS"
            $table->string('publisher');   // e.g., "John Doe"
            $table->longText('content');       // Long text field (e.g., IMG/JSON or more complex content)
            $table->text('publication_date');
            $table->string('content_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
