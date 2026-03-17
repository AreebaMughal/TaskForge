<?php

namespace Database\Factories;
use App\Models\Task;
use App\Models\Timelog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timelog>
 */
class TimelogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'minutes'    => fake()->numberBetween(30, 480),
            'note'       => fake()->sentence(),
            'task_id'    => Task::factory(),
            'created_by' => User::factory()->member(),
        ];
    }
}
