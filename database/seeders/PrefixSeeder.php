<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Business_SetUp\Prefix;

class PrefixSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prefix::insert([
            [
                'prefix_name' => 'project',
                'prefix_style' => 'PRJ-DDMM-00001',
                'prefix_format' => 'CODE-DDMM-01',
                'prefix_code' => 'PRJ',
                'separators' => '/',
                'digit_limit' => 5,
            ],
        ]);
    }
}
