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
        // Flash Sales table
        Schema::create('flash_sales', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->enum('status', ['draft', 'scheduled', 'active', 'ended'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            
            $table->index(['status', 'start_time', 'end_time']);
        });

        // Flash Sale Products pivot table
        Schema::create('flash_sale_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flash_sale_id')->constrained('flash_sales')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->decimal('flash_price', 10, 2)->nullable(); // Override price for this sale
            $table->decimal('flash_discount_percent', 5, 2)->nullable(); // Override discount
            $table->integer('stock_limit')->nullable(); // Limited quantity for flash sale
            $table->integer('sold_count')->default(0);
            $table->timestamps();
            
            $table->unique(['flash_sale_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flash_sale_products');
        Schema::dropIfExists('flash_sales');
    }
};
