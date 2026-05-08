<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@barangay.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'position' => 'Barangay Captain',
        ]);

        User::create([
            'name' => 'Official User',
            'email' => 'official@barangay.com',
            'password' => Hash::make('official123'),
            'role' => 'official',
            'position' => 'Barangay Secretary',
        ]);
        
        $this->command->info('Users created successfully!');
        $this->command->info('Admin: admin@barangay.com / admin123');
        $this->command->info('Official: official@barangay.com / official123');
    }
}