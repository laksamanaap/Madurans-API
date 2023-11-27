<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('itinerary')->insert([
            'itinerary_day' => 1,
            'itinerary_location_description' => Str::random(20),
            'itinerary_description' => Str::random(50),
        ]);
    }
}
