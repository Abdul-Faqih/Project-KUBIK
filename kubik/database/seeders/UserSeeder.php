<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Budi Santoso', 'Siti Aisyah', 'Andi Wijaya', 'Rina Kartika', 'Dewi Lestari',
            'Rizki Pratama', 'Ayu Puspita', 'Agus Kurniawan', 'Tono Hidayat', 'Wulan Sari'
        ];

        foreach ($names as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => Str::slug($name, '.') . '@student.kubik.ac.id',
                'phone_number' => '08' . rand(1000000000, 9999999999),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
