<?php

namespace Database\Seeders;

use App\Models\ClassroomStudent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('classroom_students')->insert([
            'classroom_id' => 1,
            'student_id' => 1,
        ]);
        ClassroomStudent::factory()->count(50)->create();
    }
}
