<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class EmployeeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Onboarding', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ext. Leave', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Resigned', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Dismissed', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Resigned', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Retired', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('employee_statuses')->insert($data);
    }
}
