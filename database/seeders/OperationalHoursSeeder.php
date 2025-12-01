<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Business_SetUp\OperationalHours;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OperationalHoursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        foreach($days as $day) {
            OperationalHours::updateOrCreate(
                ['day' => $day],
                [
                    'status' => in_array($day, ['Friday','Saturday']) ? 'Holiday' : 'Working Day',
                    'start_time' => '09:00',
                    'end_time' => '18:00',
                ]
            );
        }
    }
}
