<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'office' => 'ORD', 
            'email' => 'admin@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('adminpassword'), 
            'remember_token' => Str::random(10),
        ]);
    }
}
