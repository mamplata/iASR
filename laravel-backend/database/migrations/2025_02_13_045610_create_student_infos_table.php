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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('student_id');   // e.g., "190234"
            $table->string('uid');          // e.g., "1234"
            $table->string('first_name');   // e.g., "John"
            $table->string('last_name');    // e.g., "Doe"
            $table->string('program');      // e.g., "BSIT"
            $table->string('department');   // e.g., "CCS"
            $table->string('year_level');   // e.g., "4TH YEAR"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_infos');
    }
};
