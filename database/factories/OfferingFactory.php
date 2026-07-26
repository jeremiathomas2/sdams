<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'amount' => $this->faker->numberBetween(1000, 500000),
            'type' => $this->faker->randomElement(['Tithe', 'Combined Offering', 'Camp Meeting', 'Building Fund', 'Other']),
            'date' => $this->faker->date('Y-m-d'),
            'receipt_number' => $this->faker->optional()->numerify('REC-#####'),
            'fund_id' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
