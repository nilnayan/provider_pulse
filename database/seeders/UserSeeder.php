<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserNote;
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
            'password' => '12345678',
            'phone' => '917-544-1202',
            'access_level_id' => 9,
            'department_id' => 5,
            'job_title_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        User::create($data);

        User::factory(5)
            ->has(UserNote::factory()->count(rand(2, 5)))
            ->create();
    }
}