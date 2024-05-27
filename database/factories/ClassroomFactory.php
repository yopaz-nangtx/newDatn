<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::where('role', 2)->get()->pluck('id')->toArray();
        $roomIds = Room::get()->pluck('id')->toArray();

        return [
            'name' => $this->faker->words(3, true),
            'teacher_id' => $this->faker->randomElement($userIds),
            'room_id' => $this->faker->randomElement($roomIds),
            'fee' => 1000000,
        ];
    }
}
