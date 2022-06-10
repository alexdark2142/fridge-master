<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'          => $this->faker->numberBetween(1, 5),
            'freezing_room_id' => $this->faker->unique()->numberBetween(1, 54),
            'blocks'           => $this->faker->numberBetween(10, 50),
            'storage_period'   => $this->faker->dateTimeBetween('-10 days', '4 days'),
            'cost'             => $this->faker->numberBetween(10000, 100000),
            'token'            => Str::random(12),
        ];
    }
}
