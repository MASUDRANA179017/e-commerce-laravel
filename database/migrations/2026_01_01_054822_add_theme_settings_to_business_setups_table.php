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
            $table->string('theme_color_primary')->nullable()->default('#0496ff');
            $table->string('theme_color_secondary')->nullable()->default('#1a1a2e');
            $table->string('theme_color_accent')->nullable()->default('#f9c123');
            $table->string('theme_font_primary')->nullable()->default('Outfit');
            $table->string('theme_font_base_size')->nullable()->default('16px');
            $table->string('theme_header_style')->nullable()->default('Default');
            $table->string('theme_footer_style')->nullable()->default('Default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->dropColumn([
                'theme_color_primary',
                'theme_color_secondary',
                'theme_color_accent',
                'theme_font_primary',
                'theme_font_base_size',
                'theme_header_style',
                'theme_footer_style',
            ]);
        });
    }
};
