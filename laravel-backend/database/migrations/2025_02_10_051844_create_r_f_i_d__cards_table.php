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
        Schema::create('r_f_i_d__cards', function (Blueprint $table) {
            $table->id('cardId');
            $table->integer('uid');
            $table->integer('deviceId');
            $table->string('studName');
            $table->string('department');
            $table->string('program');
            $table->string('yearLevel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_f_i_d__cards');
    }
};
