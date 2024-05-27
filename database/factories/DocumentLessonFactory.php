<?php

namespace Database\Factories;

use App\Models\Document;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentLesson>
 */
class DocumentLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lessonIds = Lesson::get()->pluck('id')->toArray();
        $documentIds = Document::get()->pluck('id')->toArray();

        return [
            'lesson_id' => $this->faker->randomElement($lessonIds),
            'document_id' => $this->faker->randomElement($documentIds),
        ];
    }
}
