<?php

namespace Database\Seeders;

use App\Models\Admin\Business_SetUp\BusinessSetup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         BusinessSetup::create([
            'company_name'                => 'QBit Technologies Ltd.',
            'company_type'                => 'Private Limited Company',
            'industry'                    => 'Software Development',
            'establishment_date'          => '2020-01-15',
            'company_registration_number' => 'C-123456',
            'trade_license_number'        => 'TL-789012',
            'bin_vat_number'              => 'BIN-345678',
            'street_address'              => 'House 123, Road 15, Dhanmondi',
            'city_thana'                  => 'Dhanmondi',
            'district'                    => 'Dhaka',
            'zip_code'                    => '1205',
            'official_contact_number'     => '+8801844674502',
            'whatsapp_number'             => '+8801844674502',
            'hotline_number'              => '+8801844674503',
            'landline_number'             => '02-9876543',
            'email_address'               => 'info@qbit-tech.com',
            'website_address'             => 'https://qbit-tech.com',

            'facebook_url'   => 'https://facebook.com/qbittech',
            'facebook_status'=> true,
            'linkedin_url'   => 'https://linkedin.com/company/qbittech',
            'linkedin_status'=> true,
            'youtube_url'    => 'https://youtube.com/@qbittech',
            'youtube_status' => true,
            'twitter_url'    => '@qbittech',
            'twitter_status' => false,

            'logo'           => 'logos/main_logo.png',
            'alt_logo'       => 'logos/alt_logo.png',
            'favicon'        => 'logos/favicon.png',

            'system_name'         => 'QBit BMS',
            'file_upload_max_size'=> 10,
            'auto_backup_frequency'=> 'Daily',
            'backup_time'         => '02:00',
            'backup_retention'    => 30,
        ]);
    }
}
