<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actor>
 */
class ActorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'description' => fake()->unique()->realText(200),
            'address' => fake()->address(),
            'height' => fake()->numberBetween(150, 200) . ' cm',
            'weight' => fake()->numberBetween(50, 100) . ' kg',
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'age' => fake()->numberBetween(18, 80)
        ];
    }
}
