<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::updateOrCreate(
            ['email' => 'lourdesfilarca.corpuz@gmail.com'],  // Unique condition (email in this case)
            [
                'phone_number' => '09668001126',
                'email' => 'lourdesfilarca.corpuz@gmail.com',
                'created_at' => now(),  // Optional: Ensure timestamps are set
                'updated_at' => now(),
            ]
        );        
    }
}
