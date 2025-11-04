<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Classroom', 'Auditorium', 'Meeting Room', 'Electrical', 'Sound System',
            'Projector', 'Table', 'Chair', 'Stationery'
        ];

        foreach ($categories as $i => $cat) {
            DB::table('categories')->insert([
                'name' => $cat,
                'updated_at' => now(),
            ]);
        }
    }
}
