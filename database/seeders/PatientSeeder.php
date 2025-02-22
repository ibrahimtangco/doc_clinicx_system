<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'patient@gmail.com'], // Ensure no duplicate email
            [
                'first_name' => 'Patient',
                'last_name' => 'Account',
                'address' => 'San Pedro, Santa Lucia, Ilocos Sur',
                'userType' => 'user',
                'password' => Hash::make('Patient_12345'), // Hashed password
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Patient::updateOrCreate(
            ['user_id' => $user->id],
            [
                'telephone' => '09123456789',
                'birthday' => '1995-06-15', // Replace with actual birthdate
                'age' => now()->diffInYears(\Carbon\Carbon::parse('1995-06-15')), // Calculates accurate age
                'status' => 'Single',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }
}
