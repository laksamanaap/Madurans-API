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
            'facilities' => Str::random(100) 
        ]);
    } catch (\Exception $e) {
        \Log::error('Error inserting data: ' . $e->getMessage());
        throw $e;
    }
    }
}
