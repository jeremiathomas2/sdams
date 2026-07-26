<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement(['Sabbath Service', 'Mid-week Prayer', 'Camp Meeting', 'Youth Meeting']),
            'description' => $this->faker->sentence(),
            'location' => $this->faker->randomElement(['Main Sanctuary', 'Fellowship Hall', 'Outdoor']),
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'type' => $this->faker->randomElement(['Sabbath Service', 'Mid-week Prayer', 'Camp Meeting', 'Youth Meeting', 'Other']),
        ];
    }
}
