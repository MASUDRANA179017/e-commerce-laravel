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
        Schema::create('business_setups', function (Blueprint $table) {
            $table->id();

            //Company Information
            $table->string('company_name');
            $table->string('company_type')->nullable();
            $table->string('industry')->nullable();
            $table->date('establishment_date')->nullable();

            //Legal & Official Numbers
            $table->string('company_registration_number')->nullable();
            $table->string('trade_license_number')->nullable();
            $table->string('bin_vat_number')->nullable();

            // Address Information
            $table->text('street_address')->nullable();
            $table->string('city_thana')->nullable();
            $table->string('district')->nullable();
            $table->string('zip_code')->nullable();

            // Contact Information
            $table->string('official_contact_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('hotline_number')->nullable();
            $table->string('landline_number')->nullable();
            $table->string('email_address')->nullable();
            $table->string('website_address')->nullable();

            // Social Media Information
            $table->string('facebook_url')->nullable();
            $table->boolean('facebook_status')->default(true);
            $table->string('linkedin_url')->nullable();
            $table->boolean('linkedin_status')->default(true);
            $table->string('youtube_url')->nullable();
            $table->boolean('youtube_status')->default(true);
            $table->string('twitter_url')->nullable();
            $table->boolean('twitter_status')->default(false);

            // Branding
            $table->string('logo')->nullable();
            $table->string('alt_logo')->nullable();
            $table->string('favicon')->nullable();

            // System settings
            $table->string('system_name')->nullable();
            $table->integer('file_upload_max_size')->nullable();

            // Backup & maintenance
            $table->string('auto_backup_frequency')->nullable();
            $table->time('backup_time')->nullable();
            $table->integer('backup_retention')->nullable();

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
        Schema::dropIfExists('business_setups');
    }
};
