<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomeworkResult>
 */
class HomeworkResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::where('role', 3)->get()->pluck('id')->toArray();
        $homeworkIds = Homework::get()->pluck('id')->toArray();

        return [
            'homework_id' => $this->faker->randomElement($homeworkIds),
            'student_id' => $this->faker->randomElement($userIds),
            'score' => $this->faker->randomFloat(0, 50, 100),
            'is_finished' => 1,
        ];
    }
}
