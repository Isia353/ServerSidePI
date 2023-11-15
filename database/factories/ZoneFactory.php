<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $animalId= \App\Models\Animal::pluck('id')->all();

        return [
            'type' => fake()->randomElement(['Aquarium', 'Savannah', 'Artic','Jungle']),
            'description' => fake()->sentence,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
