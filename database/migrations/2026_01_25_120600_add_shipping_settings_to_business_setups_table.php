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
        Schema::table('business_setups', function (Blueprint $table) {
            if (!Schema::hasColumn('business_setups', 'default_shipping_method')) {
                $table->string('default_shipping_method')->default('flat_rate')->after('payment_methods');
            }
            if (!Schema::hasColumn('business_setups', 'shipping_cost_dhaka')) {
                $table->decimal('shipping_cost_dhaka', 10, 2)->default(60)->after('default_shipping_method');
            }
            if (!Schema::hasColumn('business_setups', 'shipping_cost_outside')) {
                $table->decimal('shipping_cost_outside', 10, 2)->default(120)->after('shipping_cost_dhaka');
            }
            if (!Schema::hasColumn('business_setups', 'free_shipping_threshold')) {
                $table->decimal('free_shipping_threshold', 10, 2)->default(5000)->after('shipping_cost_outside');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            if (Schema::hasColumn('business_setups', 'default_shipping_method')) {
                $table->dropColumn('default_shipping_method');
            }
            if (Schema::hasColumn('business_setups', 'shipping_cost_dhaka')) {
                $table->dropColumn('shipping_cost_dhaka');
            }
            if (Schema::hasColumn('business_setups', 'shipping_cost_outside')) {
                $table->dropColumn('shipping_cost_outside');
            }
            if (Schema::hasColumn('business_setups', 'free_shipping_threshold')) {
                $table->dropColumn('free_shipping_threshold');
            }
        });
    }
};
