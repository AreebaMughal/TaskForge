<?php

namespace Database\Factories;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'       => fake()->words(3, true),
            'status'     => 'active',
            'start_date' => now()->subDays(30),
            'due_date'   => now()->addDays(60),
            'client_id'  => Client::factory(),
            'created_by' => User::factory()->manager(),
        ];
    }
}
