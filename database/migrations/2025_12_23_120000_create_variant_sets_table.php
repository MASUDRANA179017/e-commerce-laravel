<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_sets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('attribute_set_id')->nullable();
            $table->string('sku_prefix')->nullable();
            $table->json('media_rules')->nullable();
            $table->json('variant_rules')->nullable();
            $table->json('variants')->nullable();
            $table->enum('status', ['draft','active'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->index(['category_id']);
            $table->index(['attribute_set_id']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_sets');
    }
};
