<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => 'SDA-' . $this->faker->unique()->numberBetween(1000, 9999),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'date_of_birth' => $this->faker->date('Y-m-d', '-18 years'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'marital_status' => $this->faker->randomElement(['Single', 'Married', 'Widowed', 'Divorced']),
            'phone_number' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'residential_address' => $this->faker->address(),
            'baptism_date' => $this->faker->date('Y-m-d', '-1 year'),
            'membership_class' => $this->faker->randomElement(['Baptized', 'Probation', 'Junior']),
            'membership_status' => $this->faker->randomElement(['Active', 'Inactive', 'Probation']),
            'department_ministry' => $this->faker->randomElement(['Youth', 'Women\'s Ministry', 'Men\'s Ministry', 'Children\'s Ministry', 'Music Ministry', 'None']),
        ];
    }
}
