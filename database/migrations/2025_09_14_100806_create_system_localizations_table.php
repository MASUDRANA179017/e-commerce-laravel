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
        Schema::create('system_localizations', function (Blueprint $table) {
            $table->id();
            $table->string('system_language', 8)->default('en');     // en, bn, etc.
            $table->string('timezone')->default('UTC');              // IANA TZ
            $table->string('default_currency', 3)->default('USD');   // ISO 4217
            $table->string('date_format')->default('Y-m-d');
            $table->enum('time_format', ['12','24'])->default('12');
            $table->unsignedTinyInteger('currency_decimals')->default(2);

            // “Currencies & Exchange Rates”
            $table->string('fiscal_year_start')->default('January'); // Month string or code
            $table->decimal('usd_to_bdt_rate', 12, 4)->nullable();
            $table->json('exchange_rates')->nullable();              // future expansion

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_localizations');
    }
};
