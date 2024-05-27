<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HomeworkFactory extends Factory
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
            // 'classroom_id' => $this->faker->randomElement($classIds),
            'homework_name' => $this->faker->words(3, true),
            'time' => 30,
            'end_time' => $date,
        ];
    }
}
