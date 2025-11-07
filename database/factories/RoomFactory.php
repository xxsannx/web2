<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'type' => fake()->randomElement(['Standard', 'Family', 'Premium']),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(80000, 500000),
            'image' => fake()->imageUrl(),
            'capacity' => fake()->numberBetween(1, 4),
            'available' => true,
        ];
    }
}