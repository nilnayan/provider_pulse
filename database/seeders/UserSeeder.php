<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'first_name' => 'Nilabja',
            'last_name' => 'Bhattacharya',
            'email' => 'nilabja@gmail.com',
            'password' => bcrypt('12345678'),
            'phone' => '917-544-1202',
            'access_level_id' => 9,
            'department_id' => 5,
            'job_title_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        \App\Models\User::create($data);

        \App\Models\User::factory()->count(10)->create();
    }
}
