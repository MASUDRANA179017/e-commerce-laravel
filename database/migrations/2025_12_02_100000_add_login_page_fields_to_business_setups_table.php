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
            // Login Page Customization
            $table->string('login_background')->nullable()->after('favicon');
            $table->string('login_image')->nullable()->after('login_background');
            $table->string('login_title')->nullable()->after('login_image');
            $table->string('login_tagline')->nullable()->after('login_title');
            $table->string('login_subtitle')->nullable()->after('login_tagline');
            $table->string('login_copyright')->nullable()->after('login_subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->dropColumn([
                'login_background',
                'login_image',
                'login_title',
                'login_tagline',
                'login_subtitle',
                'login_copyright',
            ]);
        });
    }
};

