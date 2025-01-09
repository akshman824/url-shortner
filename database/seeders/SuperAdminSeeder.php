<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'artistanurag09@gmail.com',
            'password' => Hash::make('password'), // Use a secure password
            'role' => 'admin',
            'team_id' => null, // No team for Super Admin
        ]);
    }
}
