<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AccessLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => '3',
                'name' => 'Provider',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '5',
                'name' => 'Supervisor',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '6',
                'name' => 'Branch Manager',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '7',
                'name' => 'HR',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '8',
                'name' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '9',
                'name' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('access_levels')->insert($data);
    }
}
