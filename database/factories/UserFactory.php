<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement(['2', '3']),
            'gender' => $this->faker->randomElement(['1', '2', '3']),
            'password' => Hash::make('password'),
            'birthday' => $this->faker->date(),
            'address' => $this->faker->address(),
        ];
    }
}
