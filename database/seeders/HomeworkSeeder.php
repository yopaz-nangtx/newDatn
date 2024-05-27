<?php

namespace Database\Seeders;

use App\Models\Homework;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = date('Y-m-d H:i:s', strtotime('+'.rand(0, 15).' day'));

        DB::table('homeworks')->insert([
            // 'classroom_id' => 1,
            'homework_name' => 'Test dinh ky',
            'time' => 30,
            'end_time' => $date,
        ]);
        Homework::factory()->count(10)->create();
    }
}
