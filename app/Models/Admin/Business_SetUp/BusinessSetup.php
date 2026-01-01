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
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'theme_color_primary',
        'theme_color_secondary',
        'theme_color_accent',
        'theme_font_primary',
        'theme_font_base_size',
        'theme_header_style',
        'theme_footer_style',
        'footer_text',
        'copyright_text',
        'payment_methods',
        'updated_by',
    ];

  // App\Models\Admin\Business_SetUp\BusinessSetup
protected $casts = [
  'official_contact_number' => 'array',
  'whatsapp_number'         => 'array',
  'hotline_number'          => 'array',
  'email_address'           => 'array',
  'payment_methods'         => 'array',
];


    // Safe accessors: accept old single strings too

   protected function officialContactNumber(): Attribute {
    return Attribute::make(
        get: function ($v) {
            if (is_array($v)) return $v;
            if (is_string($v)) {
                $d = json_decode($v, true);
                if (null !== $d) {
                    if (is_array($d)) return $d;
                    if (is_scalar($d)) return [(string) $d];
                }
            }
            return strlen((string) $v) ? [(string) $v] : [];
        }
    );
}
protected function whatsappNumber(): Attribute {
    return Attribute::make(
        get: function ($v) {
            if (is_array($v)) return $v;
            if (is_string($v)) {
                $d = json_decode($v, true);
                if (null !== $d) {
                    if (is_array($d)) return $d;
                    if (is_scalar($d)) return [(string) $d];
                }
            }
            return strlen((string) $v) ? [(string) $v] : [];
        }
    );
}
protected function hotlineNumber(): Attribute {
    return Attribute::make(
        get: function ($v) {
            if (is_array($v)) return $v;
            if (is_string($v)) {
                $d = json_decode($v, true);
                if (null !== $d) {
                    if (is_array($d)) return $d;
                    if (is_scalar($d)) return [(string) $d];
                }
            }
            return strlen((string) $v) ? [(string) $v] : [];
        }
    );
}
protected function emailAddress(): Attribute {
    return Attribute::make(
        get: function ($v) {
            if (is_array($v)) return $v;
            if (is_string($v)) {
                $d = json_decode($v, true);
                if (null !== $d) {
                    if (is_array($d)) return $d;
                    if (is_scalar($d)) return [(string) $d];
                }
            }
            return strlen((string) $v) ? [(string) $v] : [];
        }
    );
}

}
