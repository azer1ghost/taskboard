<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Board;
use Exception;

class TaskFactory extends Factory
{
    /**
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(10),
            'detail' => $this->faker->realText(random_int(20, 250)),
            'board_id' => Board::factory()
        ];
    }
}
