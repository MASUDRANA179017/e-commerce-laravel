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
        Schema::table('purchase_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_items', 'purchase_id')) {
                $table->foreignId('purchase_id')->constrained('purchases')->cascadeOnDelete()->after('id');
            }
            if (!Schema::hasColumn('purchase_items', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->after('purchase_id');
            }
            if (!Schema::hasColumn('purchase_items', 'quantity')) {
                $table->integer('quantity')->default(0)->after('product_id');
            }
            if (!Schema::hasColumn('purchase_items', 'unit_cost')) {
                $table->decimal('unit_cost', 12, 2)->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('purchase_items', 'total_cost')) {
                $table->decimal('total_cost', 12, 2)->default(0)->after('unit_cost');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            if (Schema::hasColumn('purchase_items', 'total_cost')) {
                $table->dropColumn('total_cost');
            }
            if (Schema::hasColumn('purchase_items', 'unit_cost')) {
                $table->dropColumn('unit_cost');
            }
            if (Schema::hasColumn('purchase_items', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('purchase_items', 'product_id')) {
                $table->dropConstrainedForeignId('product_id');
            }
            if (Schema::hasColumn('purchase_items', 'purchase_id')) {
                $table->dropConstrainedForeignId('purchase_id');
            }
        });
    }
};

