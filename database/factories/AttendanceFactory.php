<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttendanceFactory extends Factory
{
    public function definition()
    {
        $lessonIds = Lesson::get()->pluck('id')->toArray();
        $userIds = User::where('role', 3)->get()->pluck('id')->toArray();

        return [
            'lesson_id' => $this->faker->randomElement($lessonIds),
            'student_id' => $this->faker->randomElement($userIds),
            'reason' => $this->faker->words(20, true),
            'status' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}
