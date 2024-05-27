<?php

namespace Database\Factories;

use App\Models\Homework;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HomeworkQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $homeworkIds = Homework::get()->pluck('id')->toArray();
        $questionIds = Question::get()->pluck('id')->toArray();

        return [
            'homework_id' => $this->faker->randomElement($homeworkIds),
            'question_id' => $this->faker->randomElement($questionIds),
        ];
    }
}
