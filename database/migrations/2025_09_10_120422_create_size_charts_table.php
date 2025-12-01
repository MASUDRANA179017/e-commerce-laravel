<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('size_charts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->nullable()
                ->constrained('categories')->nullOnDelete();
            $t->string('name');
            $t->string('unit', 16)->nullable();
            $t->json('columns');
            $t->json('rows');
            $t->text('notes')->nullable();
            $t->string('image_path')->nullable();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('size_charts');
    }
};
