<?php

namespace Database\Factories;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
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
        return [
            'title'       => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status'      => 'in_progress',
            'due_date'    => now()->addDays(10),
            'project_id'  => Project::factory(),
            'created_by'  => User::factory()->member(),
        ];
    }
}
