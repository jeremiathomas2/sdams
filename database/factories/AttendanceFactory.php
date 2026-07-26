<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'member_id' => Member::factory(),
            'status' => $this->faker->randomElement(['Present', 'Absent', 'Late']),
        ];
    }
}
