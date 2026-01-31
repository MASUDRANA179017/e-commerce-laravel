<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->text('facebook_url')->nullable()->change();
            $table->text('linkedin_url')->nullable()->change();
            $table->text('youtube_url')->nullable()->change();
            $table->text('twitter_url')->nullable()->change();
            $table->text('website_address')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->string('facebook_url', 255)->nullable()->change();
            $table->string('linkedin_url', 255)->nullable()->change();
            $table->string('youtube_url', 255)->nullable()->change();
            $table->string('twitter_url', 255)->nullable()->change();
            $table->string('website_address', 255)->nullable()->change();
        });
    }
};
