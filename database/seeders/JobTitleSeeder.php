<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Nurse', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physician\'s Assistant', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Physician', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Developer', 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('job_titles')->insert($data);
    }
}
