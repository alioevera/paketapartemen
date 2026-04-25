<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReceptionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reception')->insert([
            [
                'user_nik' => '2020',
                'user_name' => 'Dennis',
                'username' => '2020',
                'password' => Hash::make('2020'),
                'role' => 'admin',
                'created_at' => now(),
            ]
        ]);
    }
}