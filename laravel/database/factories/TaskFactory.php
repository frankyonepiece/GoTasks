<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $complated_at = random_int(0,10) < 4 ? fake()->dateTimeThisYear() : null;
        return [
            'title' => fake()->name(),
            'description' => fake()->text(250),
            'complated_at' => $complated_at,
            'importent' => fake()->boolean(),
        ];
    }
}
