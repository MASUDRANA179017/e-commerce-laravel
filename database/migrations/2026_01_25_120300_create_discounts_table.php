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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique()->nullable();
            $table->enum('type', ['percentage', 'fixed', 'buy_x_get_y'])->default('percentage');
            $table->decimal('value', 10, 2);
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->integer('usage_limit')->nullable();
            $table->integer('usage_count')->default(0);
            $table->integer('usage_limit_per_customer')->nullable();
            $table->enum('applies_to', ['all_products', 'specific_products', 'specific_categories'])->default('all_products');
            $table->longText('applicable_products')->nullable(); // JSON: product IDs
            $table->longText('applicable_categories')->nullable(); // JSON: category IDs
            $table->decimal('minimum_purchase', 10, 2)->nullable();
            $table->decimal('minimum_product_quantity', 10, 2)->nullable();
            $table->enum('customer_type', ['all', 'new', 'existing'])->default('all');
            $table->boolean('is_flash_sale')->default(false);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
