<?php

namespace Database\Seeders;

use App\Models\FreezingRoom;
use App\Models\Location;
use Illuminate\Database\Seeder;

class FreezingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $locations = Location::all();
        $temperatures = [0, -4, -8, -12, -16, -20, -24, -28, -32];
        $FreezingRoom = new FreezingRoom();

        foreach ($locations as $location) {
            $item = 0;
            foreach ($temperatures as $temperature) {
                $FreezingRoom::create([
                    'name' => "Room_$location->id" . $item++,
                    'location_id' => $location->id,
                    'temperature' => $temperature,
                    'total_blocks' => 50,
                ]);
            }
        }
    }
}
