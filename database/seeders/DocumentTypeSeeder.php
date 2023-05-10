<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $data = [
            [
                'id' => '1',
                'name' => 'Review',
				'description' => 'for review',
				'allowed_formats' => 'xls,pdf',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => '2',
                'name' => 'Photo Id',
				'description' => 'for photos',
				'allowed_formats' => 'jpg,png',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('document_types')->insert($data);
    }
}
