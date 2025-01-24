<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('password123'), // Always hash passwords
        // ]);

        // User::create([
        //     'name' => 'Test User',
        //     'email' => 'test@test.com',
        //     'password' => Hash::make('test123'), // Always hash passwords
        // ]);

        User::create([
            'name' => 'Admin',
            'email' => 'Admin@bhavani.com',
            'password' => Hash::make('admin@123'), // Always hash passwords
        ]);
    }
}
