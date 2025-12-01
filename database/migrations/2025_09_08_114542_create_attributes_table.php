<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('attributes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('slug')->unique();          // e.g., color, storage
            $table->string('name');                    // e.g., Color
            $table->string('code', 32)->nullable();    // e.g., CLR
            $table->enum('type', ['select','swatch'])->default('select');
            $table->json('edit_fields')->nullable();   // e.g., ["name","code","color"]
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('attributes');
    }
};
