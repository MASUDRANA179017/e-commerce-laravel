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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('notification_frequency', [
                    'instant', 'hourly_digest', 'daily_digest', 'weekly_summary'
                    ])->default('instant');
            $table->string('quiet_hours')->nullable(); 
            $table->json('notification_channels')->nullable(); 
            $table->enum('priority_level', [
                    'all', 'high_priority', 'critical'
                    ])->default('all');
            $table->enum('notification_sound', [
                    'default', 'minimal', 'none'
                    ])->default('default');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
