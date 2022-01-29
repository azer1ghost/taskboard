<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Exception;

class BoardFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(random_int(10, 22)),
            'user_id' => User::factory(),
        ];
    }
}
