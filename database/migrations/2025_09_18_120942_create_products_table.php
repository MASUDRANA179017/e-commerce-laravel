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
        Schema::create('products', function (Blueprint $table) {
           $table->bigIncrements('id');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnUpdate();
            $table->foreignId('attribute_set_id')->nullable()->constrained('attribute_sets')->cascadeOnUpdate();
            // Define variant_rule_id without a foreign key constraint because the
            // referenced table may be created in a later migration. This avoids
            // migration ordering FK errors during db rebuilds.
            $table->unsignedBigInteger('variant_rule_id')->nullable();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_desc')->nullable();

            $table->enum('status', ['Draft','Active','Archived'])->default('Draft');
            $table->boolean('featured')->default(false);
            $table->boolean('allow_backorder')->default(false);
            $table->boolean('variant_wise_image')->default(false);

            $table->string('seo_title')->nullable();
            $table->text('seo_desc')->nullable();
            $table->text('seo_keys')->nullable();

            $table->timestamps();
            $table->index(['brand_id','status']);
            $table->index(['attribute_set_id']);
            $table->index(['variant_rule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
