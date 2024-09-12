<?php

namespace Database\Seeders;

use App\Models\UpdateHistory;
use Database\Factories\updateHistoryFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UpdateHistory::factory(5)->create();
    }
}
