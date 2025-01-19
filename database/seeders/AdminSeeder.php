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
            ['email' => 'ibrahim.tangco@lorma.edu'], // Ensure no duplicate email
            [
                'first_name' => 'Ibrahim',
                'last_name' => 'Tangco',
                'address' => 'Buliclic, Santa Lucia, Ilocos Sur',
                'userType' => 'admin',
                'password' => Hash::make('Ibrahim_12345'), // Hashed password
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
