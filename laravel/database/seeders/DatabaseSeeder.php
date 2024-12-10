<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::factory()->create([
            'userID' => 1,
            'firstName' => 'Test User',
            'lastName' => 'Test User',
            'username' => 'Test User',
            'nickname' => 'Test User',
            'role' => 'Test User',
            'dateOfBirth' => 'Test User',
            'email' => 'test@example.com',
            'phoneNo' => 'Test User',
            'password' => bcrypt('password'),
            'status' => 'Test User',
            'created_at' => 'Test User',
            'updated_at' => 'Test User',
        ]);
    }
}
