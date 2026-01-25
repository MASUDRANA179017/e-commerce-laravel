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
            $table->string('theme_button_text_color')->nullable()->default('#ffffff');
            $table->string('theme_secondary_button_bg')->nullable()->default('#f5f5f5');
            $table->string('theme_secondary_button_text')->nullable()->default('#333333');
            $table->string('theme_color_link')->nullable()->default('#0496ff');
            $table->string('theme_color_text')->nullable()->default('#333333');
            $table->string('theme_color_heading')->nullable()->default('#1a1a2e');
            $table->string('theme_color_badge')->nullable()->default('#f9c123');
            $table->string('theme_color_border')->nullable()->default('#e0e0e0');
            $table->string('theme_color_input_focus')->nullable()->default('#0496ff');
            $table->string('theme_color_success')->nullable()->default('#28a745');
            $table->string('theme_color_danger')->nullable()->default('#dc3545');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->dropColumn([
                'theme_button_text_color',
                'theme_secondary_button_bg',
                'theme_secondary_button_text',
                'theme_color_link',
                'theme_color_text',
                'theme_color_heading',
                'theme_color_badge',
                'theme_color_border',
                'theme_color_input_focus',
                'theme_color_success',
                'theme_color_danger',
            ]);
        });
    }
};
