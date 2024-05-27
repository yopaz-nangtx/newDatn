<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LessonHomework>
 */
class LessonHomeworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lessonIds = Lesson::get()->pluck('id')->toArray();
        $homeworkIds = Homework::get()->pluck('id')->toArray();

        return [
            'lesson_id' => $this->faker->randomElement($lessonIds),
            'homework_id' => $this->faker->randomElement($homeworkIds),
        ];
    }
}
