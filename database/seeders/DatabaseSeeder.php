<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Sales;
use App\Models\UpdateHistory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'AdminUser',
            'email' => 'admin@example.com',
            'password' => '123456',
        ]);
        Admin::create([
            'name' => 'admin',
            'user_id' => $user->id,
        ]);


        $user = User::create([
            'username' => 'Ys.Hion',
            'email' => 'sales@example.com',
            'password' => '123456',
        ]);
        Sales::create([
            'name' => 'Hion',
            'user_id' => $user->id,
            'region' => 'Malaysia'
        ]);

        $user = User::create([
            'username' => 'Jiawei.Lai',
            'email' => 'sales2@example.com',
            'password' => '123456',
        ]);
        Sales::create([
            'name' => 'Jiawei',
            'user_id' => $user->id,
            'region' => 'Malaysia'
        ]);

    }
}
