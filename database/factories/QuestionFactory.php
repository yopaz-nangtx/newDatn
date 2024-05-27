<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Homework;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $homeworkIds = Homework::get()->pluck('id')->toArray();
        $examIds = Exam::get()->pluck('id')->toArray();

        return [
            'question' => $this->faker->words(10, true),
            'option_1' => $this->faker->words(10, true),
            'option_2' => $this->faker->words(10, true),
            'option_3' => $this->faker->words(10, true),
            'option_4' => $this->faker->words(10, true),
            'answer' => $this->faker->randomElement(['option_1', 'option_2', 'option_3', 'option_4']),
        ];
    }
}
