<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NotificationFactory extends Factory
{
    public function definition()
    {
        $userIds = User::get()->pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'message' => $this->faker->sentence(),
            'date' => $this->faker->dateTime(),
        ];
    }
}
