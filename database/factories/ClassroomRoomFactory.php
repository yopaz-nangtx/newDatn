<?php

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassroomRoomFactory extends Factory
{
    public function definition(): array
    {
        $classIds = Classroom::get()->pluck('id')->toArray();
        $roomIds = Room::get()->pluck('id')->toArray();

        return [
            'classroom_id' => $this->faker->randomElement($classIds),
            'room_id' => $this->faker->randomElement($roomIds),
        ];
    }
}
