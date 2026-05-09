<?php

namespace Database\Seeders;

use App\Models\EventVenue;
use Illuminate\Database\Seeder;

class EventVenueSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Grand Function Hall',
                'description' => 'Large hall for weddings, birthdays, seminars, and corporate events.',
                'capacity' => 150,
                'rate_per_hour' => 2500,
                'location' => 'Ground Floor',
                'status' => 'available',
            ],
            [
                'name' => 'Conference Room A',
                'description' => 'Private room for meetings, trainings, and small seminars.',
                'capacity' => 40,
                'rate_per_hour' => 1200,
                'location' => '2nd Floor',
                'status' => 'available',
            ],
            [
                'name' => 'Garden Area',
                'description' => 'Outdoor venue for parties and celebrations.',
                'capacity' => 100,
                'rate_per_hour' => 1800,
                'location' => 'Outdoor Area',
                'status' => 'available',
            ],
            [
                'name' => 'Pool Side',
                'description' => 'Pool area for casual events and private gatherings.',
                'capacity' => 80,
                'rate_per_hour' => 2000,
                'location' => 'Pool Area',
                'status' => 'available',
            ],
        ];

        foreach ($venues as $venue) {
            EventVenue::updateOrCreate(
                ['name' => $venue['name']],
                $venue
            );
        }
    }
}