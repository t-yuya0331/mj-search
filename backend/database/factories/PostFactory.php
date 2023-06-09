<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'target' => $this->faker->numberBetween(1, 4),
            'description' => $this->faker->paragraph,
            'date' => $this->faker->date,
            'time' => $this->faker->time,
            'number' => $this->faker->randomDigit,
            'location' => $this->faker->address,
            'role_id' => $this->faker->numberBetween(1, 2),
            'status' => $this->faker->numberBetween(1, 2),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
            ];
        });
    }
}
