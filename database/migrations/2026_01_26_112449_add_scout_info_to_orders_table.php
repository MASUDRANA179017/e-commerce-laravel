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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('scout_full_name')->nullable()->after('status');
            $table->string('scout_bs_id')->nullable()->after('scout_full_name');
            $table->string('scout_unit_name')->nullable()->after('scout_bs_id');
            $table->string('scout_leader_name')->nullable()->after('scout_unit_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['scout_full_name', 'scout_bs_id', 'scout_unit_name', 'scout_leader_name']);
        });
    }
};
