<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'type' => $this->faker->randomElement(['In', 'Out']),
            'from_church' => $this->faker->city() . ' SDA Church',
            'to_church' => $this->faker->city() . ' SDA Church',
            'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']),
            'request_date' => $this->faker->date('Y-m-d'),
            'approval_date' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
