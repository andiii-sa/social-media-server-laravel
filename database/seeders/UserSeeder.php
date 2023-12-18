<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'a1',
            'name' => 'a1 a1 a1',
            'email' => 'a1' . '@gmail.com',
            'password' => Hash::make('123123'),
        ]);
        DB::table('users')->insert([
            'username' => 'a2',
            'name' => 'a2 a2 a2',
            'email' => 'a2' . '@gmail.com',
            'password' => Hash::make('123123'),
        ]);
        DB::table('users')->insert([
            'username' => 'a3',
            'name' => 'a3 a3 a3',
            'email' => 'a3' . '@gmail.com',
            'password' => Hash::make('123123'),
        ]);
        DB::table('users')->insert([
            'username' => 'a4',
            'name' => 'a4 a4 a4',
            'email' => 'a4' . '@gmail.com',
            'password' => Hash::make('123123'),
        ]);
        DB::table('users')->insert([
            'username' => 'u1',
            'name' => 'u1 u1 u1',
            'email' => 'u1' . '@gmail.com',
            'password' => Hash::make('123123'),
            'role' => 'user',
        ]);
    }
}
