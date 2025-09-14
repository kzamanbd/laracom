<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->admin()->create([
            'name' => 'Site Admin',
            'email' => 'admin@example.com',
        ]);

        User::factory()->vendor()->create([
            'name' => 'Site Vendor',
            'email' => 'vendor@example.com',
        ]);

        User::factory()->customer()->create([
            'name' => 'Site Customer',
            'email' => 'customer@example.com',
        ]);

        User::factory()->count(50)->vendor()->create();
        User::factory()->count(10)->customer()->create();
    }
}
