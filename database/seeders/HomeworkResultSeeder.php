<?php

namespace Database\Seeders;

use App\Models\HomeworkResult;
use Illuminate\Database\Seeder;

class HomeworkResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HomeworkResult::factory()->count(50)->create();
    }
}
