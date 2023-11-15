<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = [1,2,3,4,5];
        return [
            'title' => fake()->sentence,
            'level' => fake()->randomElement($levels),
            'finished' => fake()->boolean,
            'description' => fake()->paragraph,
        ];
    }
}
