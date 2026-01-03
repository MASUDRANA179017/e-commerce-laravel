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
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'purchase_number')) {
                $table->string('purchase_number')->unique()->after('id');
            }
            if (!Schema::hasColumn('purchases', 'vendor_id')) {
                $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnUpdate()->restrictOnDelete()->after('purchase_number');
            }
            if (!Schema::hasColumn('purchases', 'purchase_date')) {
                $table->date('purchase_date')->after('vendor_id');
            }
            if (!Schema::hasColumn('purchases', 'expected_delivery_date')) {
                $table->date('expected_delivery_date')->nullable()->after('purchase_date');
            }
            if (!Schema::hasColumn('purchases', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0)->after('expected_delivery_date');
            }
            if (!Schema::hasColumn('purchases', 'status')) {
                $table->string('status', 32)->default('pending')->after('total_amount');
            }
            if (!Schema::hasColumn('purchases', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('purchases', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('purchases', 'total_amount')) {
                $table->dropColumn('total_amount');
            }
            if (Schema::hasColumn('purchases', 'expected_delivery_date')) {
                $table->dropColumn('expected_delivery_date');
            }
            if (Schema::hasColumn('purchases', 'purchase_date')) {
                $table->dropColumn('purchase_date');
            }
            if (Schema::hasColumn('purchases', 'vendor_id')) {
                $table->dropConstrainedForeignId('vendor_id');
            }
            if (Schema::hasColumn('purchases', 'purchase_number')) {
                $table->dropUnique(['purchase_number']);
                $table->dropColumn('purchase_number');
            }
        });
    }
};

