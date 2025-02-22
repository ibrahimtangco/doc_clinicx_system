<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'staff@gmail.com'], // Ensure no duplicate email
            [
                'first_name' => 'Staff',
                'last_name' => 'Account',
                'address' => 'San Pedro, Santa Lucia, Ilocos Sur',
                'userType' => 'staff',
                'password' => Hash::make('Staff_12345'), // Hashed password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }
}
