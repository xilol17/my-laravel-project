<?php

namespace Database\Factories;

use App\Models\project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class updateHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'updateInfo' => fake()->company(),
            'project_id' => project::factory(),
        ];
    }
}
