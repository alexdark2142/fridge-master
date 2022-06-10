<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create();
        Booking::factory()->count(9)->create();

        $this->call([
            LocationSeeder::class,
            FreezingRoomSeeder::class
        ]);
    }
}
