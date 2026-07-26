<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FundFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Building Fund', 'Mission Fund', 'Youth Fund', 'Welfare Fund', 'Education Fund']),
            'description' => $this->faker->sentence(),
            'balance' => $this->faker->numberBetween(0, 500000),
        ];
    }
}
