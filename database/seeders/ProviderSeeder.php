<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Provider;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'dentist@gmail.com'], // Ensure no duplicate email
            [
                'first_name' => 'Dentist',
                'last_name' => 'Account',
                'address' => 'San Pedro, Santa Lucia, Ilocos Sur',
                'userType' => 'superadmin',
                'password' => Hash::make('Dentist_12345'), // Hashed password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Create or update provider entry
        Provider::updateOrCreate(
            ['user_id' => $user->id], // Ensure each user has only one provider record
            [
                'title' => 'Dr.', // Example title (adjust as needed)
                'reg_number' => '123456', // Example registration number (adjust as needed)
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
