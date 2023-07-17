<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserStatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=1; $i<=date('n'); $i++) {
            foreach (User::where('access_level_id', 3)->get() as $user) {
                $period = date('Y-') . sprintf('%02d', $i) . '-01';
                $num_patients = rand(5, 50);
                $comm_rt = rand(50, 100);
                $data = [
                    'user_id' => $user->id,
                    'period' => $period,
                    'num_patients' => rand(5, 50),
                    'comm' => $num_patients * $comm_rt,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                DB::table('user_stats')->insert($data);
            }
        }
    }
}
