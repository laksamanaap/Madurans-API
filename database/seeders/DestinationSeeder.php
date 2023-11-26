<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomText = Str::random(50) . '.png';

    try {
        DB::table('destination')->insert([
            'images' => $randomText,
            'title' => Str::random(10),
            'rating' => floatval(4.5),
            'trending' => (bool) rand(0, 1),
            'location' => Str::random(10),
            'description' => Str::random(100),
            'facilities' => Str::random(100) // Make sure this value is valid according to constraints
        ]);
    } catch (\Exception $e) {
        // Log the exception for debugging
        \Log::error('Error inserting data: ' . $e->getMessage());
        // Re-throw the exception to halt execution and see the full stack trace
        throw $e;
    }
    }
}
