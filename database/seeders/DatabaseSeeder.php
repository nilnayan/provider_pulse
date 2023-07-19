<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

//          \App\Models\User::create([
//              'first_name' => 'Nil',
//              'last_name' => 'Bhattacharya',
//              'email' => 'nilabja@gmail.com',
//              'password' => bcrypt('12345678')
//          ]);

        $this->call(AccessLevelSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(DocumentTypeSeeder::class);
        $this->call(EmployeeStatusSeeder::class);
        $this->call(JobTitleSeeder::class);
        $this->call(SatisfactionLevelSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UserStatSeeder::class);
    }
}
