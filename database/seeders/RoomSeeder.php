<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Room A1', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A2', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A3', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A4', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A5', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A6', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A7', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A8', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A9', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A10', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A11', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A12', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A13', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A14', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A15', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A16', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A17', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A18', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A19', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A20', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A21', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A22', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A23', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A24', 'description' => 'Have fan, air, 20 chair, table'],
            ['name' => 'Room A25', 'description' => 'Have fan, air, 20 chair, table'],
        ];
        DB::table('rooms')->insert($data);
    }
}
