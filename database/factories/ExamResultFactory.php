<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ExamResultFactory extends Factory
{
    public function definition()
    {
        $userIds = User::where('role', 3)->get()->pluck('id')->toArray();
        $examIds = Exam::get()->pluck('id')->toArray();

        return [
            'exam_id' => $this->faker->randomElement($examIds),
            'student_id' => $this->faker->randomElement($userIds),
            'score' => $this->faker->randomFloat(0, 50, 100),
        ];
    }
}
