<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
        ]);
        User::create([
            'name' => 'First Manager',
            'email' => 'manager1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'manager',
        ]);
        User::create([
            'name' => 'Member',
            'email' => 'member@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'member',
        ]);
        User::create([
            'name' => 'First Member',
            'email' => 'member1@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'member',
        ]);
        User::create([
            'name' => 'Second Member',
            'email' => 'member2@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'member',
        ]);

    }
}
