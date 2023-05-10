<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Cardiology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dermatology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Epidemiology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'General Practice', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technology', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('departments')->insert($data);
    }
}
