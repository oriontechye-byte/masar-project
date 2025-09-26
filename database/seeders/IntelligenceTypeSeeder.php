<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntelligenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the 8 intelligence types
        $types = [
            ['name' => 'الذكاء الاجتماعي'],
            ['name' => 'الذكاء البصري - الصوري'],
            ['name' => 'الذكاء الوجداني - الذاتي'],
            ['name' => 'الذكاء الجسدي - الحركي'],
            ['name' => 'الذكاء المنطقي'],
            ['name' => 'الذكاء الطبيعي'],
            ['name' => 'الذكاء اللغوي'],
            ['name' => 'الذكاء الموسيقي'],
        ];

        // Insert the data into the 'intelligence_types' table
        DB::table('intelligence_types')->insert($types);
    }
}