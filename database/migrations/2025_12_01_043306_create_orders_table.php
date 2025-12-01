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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number', 50)->unique();
            
            // Customer Info
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email');
            $table->string('phone', 20);
            
            // Shipping Address
            $table->text('address');
            $table->string('address2')->nullable();
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('zip_code', 20);
            $table->string('country', 100)->default('Bangladesh');
            
            // Order Details
            $table->text('notes')->nullable();
            $table->string('payment_method', 50);
            $table->string('payment_status', 50)->default('pending'); // pending, paid, failed
            $table->string('transaction_id')->nullable();
            
            // Amounts
            $table->decimal('subtotal', 12, 2);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('shipping', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('total', 12, 2);
            
            // Coupon
            $table->string('coupon_code', 50)->nullable();
            
            // Status
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned'])->default('pending');
            
            $table->timestamps();
            
            $table->index(['user_id', 'status']);
            $table->index(['order_number']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
