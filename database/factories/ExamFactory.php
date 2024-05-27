<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ExamFactory extends Factory
{
    public function definition()
    {
        $date = date('Y-m-d H:i:s', strtotime('+'.rand(0, 15).' day'));
        $classIds = Classroom::get()->pluck('id')->toArray();

        return [
            'classroom_id' => $this->faker->randomElement($classIds),
            'exam_name' => $this->faker->words(3, true),
            'time' => 60,
            'end_time' => $date,
        ];
    }
}
