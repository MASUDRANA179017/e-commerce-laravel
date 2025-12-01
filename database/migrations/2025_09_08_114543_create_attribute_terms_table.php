<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('attribute_terms', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();
            $table->string('slug');                    // e.g., red, 128, i5, n1
            $table->string('name');                    // e.g., Red, 128GB, Intel i5
            $table->string('code', 32)->nullable();    // e.g., RED, 128, I5
            $table->string('unit', 32)->nullable();    // e.g., EU, US
            $table->string('color', 16)->nullable();   // e.g., #ef4444
            $table->boolean('has_border')->default(false);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->unique(['attribute_id', 'slug']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('attribute_terms');
    }
};
