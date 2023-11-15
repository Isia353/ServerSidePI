<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->paragraph,
            'date' => fake()->dateTimeBetween('+1 week', '+1 month'),
            'booking' => fake()->boolean,
            'zone_id' => Zone::inRandomOrder()->first()->id,

        ];
    }
}
