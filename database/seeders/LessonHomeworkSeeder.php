<?php

namespace Database\Seeders;

use App\Models\LessonHomework;
use Illuminate\Database\Seeder;

class LessonHomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LessonHomework::factory()->count(50)->create();
    }
}
