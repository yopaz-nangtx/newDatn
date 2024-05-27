<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = date('Y-m-d H:i:s', strtotime('+'.rand(0, 15).' day'));
        $classIds = Classroom::get()->pluck('id')->toArray();

        return [
            'classroom_id' => $this->faker->randomElement($classIds),
            'lesson_name' => $this->faker->words(3, true),
            'start_time' => $date,
            'is_finished' => $this->faker->randomElement([0, 1]),
            'end_time' => date('Y-m-d H:i:s', strtotime('+2 hour', strtotime($date))),
        ];
    }
}
