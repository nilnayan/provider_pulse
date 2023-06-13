<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SatisfactionLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Very Unhappy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slightly Unhappy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Content', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Slightly Happy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Very Happy', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('satisfaction_levels')->insert($data);
    }
}
