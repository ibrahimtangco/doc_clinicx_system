<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Ensure no duplicate email
            [
                'first_name' => 'Admin',
                'last_name' => 'Account',
                'address' => 'Buliclic, Santa Lucia, Ilocos Sur',
                'userType' => 'admin',
                'password' => Hash::make('Admin_12345'), // Hashed password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
