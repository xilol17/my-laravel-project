<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\project>
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
//        $table->string('name');
//        $table->date('visitDate')->nullable();
//        $table->timestamp('startDate')->timestamp();
//        $table->timestamp('lastUpdateDate')->nullable();
//        $table->string('turnKey');
//        $table->string('status');
//        $table->string('Region');
//        $table->string('customerName');
//        $table->string('salesName');
//        $table->string('products');
//        $table->string('SI');
//        $table->string('winRate')->default(0);
        return [
            'name' => fake()->company(),
            'visitDate' => fake()->date('Y-m-d'),
            'disStartDate' => now(),
            'turnKey' => 'NO',
            'region' => fake()->country(),
            'customerName' => fake()->name(),
            'salesName' => fake()->name(),
            'SI' => 'NO'
        ];
    }
}
