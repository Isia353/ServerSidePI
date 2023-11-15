<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AnimalFactory extends Factory
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
            'sex' => fake()->randomElement(['male', 'female']),
            'name' => fake()->name,
            'img' => fake()->imageUrl( 200,200, 'animals'),
            'conservation_state' => fake()->randomElement(['Endangered', 'Vulnerable', 'Least Concern']),
          //  'ZONE_ ID' => fake()->randomElement(['Endangered', 'Vulnerable', 'Least Concern']),
        ];
    }
}
