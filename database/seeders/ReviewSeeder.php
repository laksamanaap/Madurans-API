<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('review')->insert([
            'rating' => 4,
            'description' => 'Destinasi wisata kerapan sapi di Madura menyajikan pengalaman seru dengan perpaduan tradisi dan kecepatan. Acara ini tidak hanya menyuguhkan pertandingan seru antara sapi yang berlomba dengan kecepatan tinggi, tetapi juga memperkenalkan pengunjung pada keindahan budaya Madura.',
        ]);
    }
}
