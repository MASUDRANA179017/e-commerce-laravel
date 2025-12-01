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
        Schema::create('brand_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('category'); 
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->integer('order')->default(0);
            $table->string('logo')->nullable();
            $table->text('description')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->boolean('top')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_templates');
    }
};
