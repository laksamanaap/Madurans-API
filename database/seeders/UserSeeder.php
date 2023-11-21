<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert the first user
        $randomText = Str::random(50) . '.png';
        DB::table('users')->insert([
            'profile_image' => $randomText,
            'username' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

           User::factory()
            ->count(10)
            ->create([
                'profile_image' => function () {
                    return Str::random(50) . '.png';
                },
            ]);
    }
}
