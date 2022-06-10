<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Wilmington (North Carolina)',
                'timezone' => 'US/Eastern',
            ],
            [
                'name' => 'Portland (Oregon)',
                'timezone' => 'US/Pacific',
            ],
            [
                'name' => 'Toronto',
                'timezone' => 'America/Toronto',
            ],
            [
                'name' => 'Warsaw',
                'timezone' => 'Europe/Warsaw',
            ],
            [
                'name' => 'Valencia',
                'timezone' => 'Europe/Madrid',
            ],
            [
                'name' => 'Shanghai',
                'timezone' => 'Asia/Shanghai',
            ],
        ];

        foreach ($locations as $location) {
            Location::create([
                'name' => $location['name'],
                'timezone' => $location['timezone'],
            ]);
        }
    }
}
