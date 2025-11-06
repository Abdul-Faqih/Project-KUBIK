<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Rooms', 'Items'];

        foreach ($types as $i => $type) {
            DB::table('types')->insert([
                'name' => $type,
                'updated_at' => now(),
            ]);
        }
    }
}
