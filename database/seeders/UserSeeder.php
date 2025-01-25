<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@user.com',
            'password' => Hash::make('user'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);
    }
}
