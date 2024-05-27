<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassroomStudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::where('role', 3)->get()->pluck('id')->toArray();
        $classIds = Classroom::get()->pluck('id')->toArray();

        return [
            'classroom_id' => $this->faker->randomElement($classIds),
            'student_id' => $this->faker->randomElement($userIds),
        ];

    }
}
