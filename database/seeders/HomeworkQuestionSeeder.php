<?php

namespace Database\Seeders;

use App\Models\HomeworkQuestion;
use Illuminate\Database\Seeder;

class HomeworkQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeworkQuestion::factory()->count(50)->create();
    }
}
