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
            if (!Schema::hasColumn('business_setups', 'company_name')) {
                $table->string('company_name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('business_setups', 'company_address')) {
                $table->text('company_address')->nullable()->after('company_name');
            }
            if (!Schema::hasColumn('business_setups', 'company_phone')) {
                $table->string('company_phone')->nullable()->after('company_address');
            }
            if (!Schema::hasColumn('business_setups', 'company_email')) {
                $table->string('company_email')->nullable()->after('company_phone');
            }
            if (!Schema::hasColumn('business_setups', 'dashboard_copyright')) {
                $table->string('dashboard_copyright')->nullable()->after('company_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->dropColumn(['company_name', 'company_address', 'company_phone', 'company_email', 'dashboard_copyright']);
        });
    }
};
