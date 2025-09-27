<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First, run the other seeders
        $this->call([
            IntelligenceTypeSeeder::class,
            QuestionSeeder::class,
        ]);

        // Then, create the Admin User
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@masar.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
