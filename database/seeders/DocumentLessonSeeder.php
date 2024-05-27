<?php

namespace Database\Seeders;

use App\Models\DocumentLesson;
use Illuminate\Database\Seeder;

class DocumentLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentLesson::factory()->count(20)->create();

    }
}
