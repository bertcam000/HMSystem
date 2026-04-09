<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feature;
use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'name' => 'Test User2',
        //     'email' => 'test2@example.com',
        //     'role' => 'staff',
        // ]);

        Feature::insert([
            ['name' => 'Private balcony'],
            ['name' => 'Work desk'],
            ['name' => 'Seating area'],
            ['name' => 'Large windows']
        ]);

        Facility::insert([
            ['name' => 'High speed WiFi'],
            ['name' => 'Flat screen TV'],
            ['name' => 'Mini fridge'],
            ['name' => 'Air conditioning'],
            ['name' => 'Coffee maker'],
            ['name' => 'Room service']
        ]);
        
    }
}
