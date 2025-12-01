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
        Schema::create('prefixes', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_name');               // Required
            $table->string('prefix_style')->nullable();  // From left card
            $table->string('prefix_format')->nullable(); // e.g., CODE-DD/MM-01
            $table->string('prefix_code')->nullable();   // Input
            $table->string('separators')->nullable();    // Input
            $table->integer('digit_limit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefixes');
    }
};
