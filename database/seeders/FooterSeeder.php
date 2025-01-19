<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Footer::updateOrCreate(
            ['description' => 'Filarca - Rabena Dental Clinic © 2025'], // Condition to check existing record
            [
                'description' => 'Filarca - Rabena Dental Clinic © 2025',
                'created_at' => now(), // Optional: Ensure timestamps are set
                'updated_at' => now(), // Optional: Update timestamp if record exists
            ]
        );
    }
}

