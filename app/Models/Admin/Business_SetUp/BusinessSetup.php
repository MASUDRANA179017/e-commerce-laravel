<?php

namespace App\Models\Admin\Business_SetUp;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BusinessSetup extends Model
{
    protected $fillable = [
        'company_name',
        'company_type',
        'industry',
        'establishment_date',
        'company_registration_number',
        'trade_license_number',
        'bin_vat_number',
        'street_address',
        'city_thana',
        'district',
        'zip_code',
        'official_contact_number',
        'whatsapp_number',
        'hotline_number',
        'landline_number',
        'email_address',
        'website_address',
        'facebook_url',
        'facebook_status',
        'linkedin_url',
        'linkedin_status',
        'youtube_url',
        'youtube_status',
        'twitter_url',
        'twitter_status',
        'logo',
        'alt_logo',
        'favicon',
        'login_background',
        'login_image',
        'login_title',
        'login_tagline',
        'login_subtitle',
        'login_copyright',
        'system_name',
        'file_upload_max_size',
        'auto_backup_frequency',
        'backup_time',
        'backup_retention',
        'updated_by',
    ];

  // App\Models\Admin\Business_SetUp\BusinessSetup
protected $casts = [
  'official_contact_number' => 'array',
  'whatsapp_number'         => 'array',
  'hotline_number'          => 'array',
  'email_address'           => 'array',
];


    // Safe accessors: accept old single strings too

   protected function officialContactNumber(): Attribute {
    return Attribute::make(
        get: fn($v) => is_array($v) ? $v : (strlen((string)$v) ? [(string)$v] : [])
    );
}
protected function whatsappNumber(): Attribute {
    return Attribute::make(
        get: fn($v) => is_array($v) ? $v : (strlen((string)$v) ? [(string)$v] : [])
    );
}
protected function hotlineNumber(): Attribute {
    return Attribute::make(
        get: fn($v) => is_array($v) ? $v : (strlen((string)$v) ? [(string)$v] : [])
    );
}
protected function emailAddress(): Attribute {
    return Attribute::make(
        get: fn($v) => is_array($v) ? $v : (strlen((string)$v) ? [(string)$v] : [])
    );
}

}
