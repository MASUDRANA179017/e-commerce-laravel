<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->text('instagram_url')->nullable()->after('twitter_status');
            $table->boolean('instagram_status')->default(false)->after('instagram_url');
            $table->text('tiktok_url')->nullable()->after('instagram_status');
            $table->boolean('tiktok_status')->default(false)->after('tiktok_url');
        });
    }

    public function down(): void
    {
        Schema::table('business_setups', function (Blueprint $table) {
            $table->dropColumn(['instagram_url', 'instagram_status', 'tiktok_url', 'tiktok_status']);
        });
    }
};
