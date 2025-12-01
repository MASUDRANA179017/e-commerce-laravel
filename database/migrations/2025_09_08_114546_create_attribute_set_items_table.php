<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('attribute_set_items', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('attribute_set_id')->constrained('attribute_sets')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('attribute_id')->constrained('attributes')->cascadeOnDelete();
            $table->foreignId('attribute_term_id')->constrained('attribute_terms')->cascadeOnDelete();
            $table->boolean('is_variant')->default(false);
            $table->boolean('is_filter')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['attribute_set_id', 'attribute_term_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('attribute_set_items');
    }
};
