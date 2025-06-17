<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bijimail.com',
            'password' => Hash::make('admin123'),
            'level' => 1,
        ]);
        User::factory()->create([
            'name' => 'Dania',
            'email' => 'daniasanitasi@gmail.com',
            'password' => Hash::make('dania123'),
            'level' => 1,
        ]);
        User::factory()->create([
            'name' => 'Dila',
            'email' => 'dilautamisanitasi@gmail.com',
            'password' => Hash::make('dila123'),
            'level' => 1,
        ]);
    }
}
