<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PresenceEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presence_employee')->insert([
            'id' => 1,
            'employeeId' => 1,
            'dayId' => 1,
            'dayName' => 'Senin',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_employee')->insert([
            'id' => 2,
            'employeeId' => 1,
            'dayId' => 2,
            'dayName' => 'Selasa',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_employee')->insert([
            'id' => 3,
            'employeeId' => 2,
            'dayId' => 1,
            'dayName' => 'Senin',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_employee')->insert([
            'id' => 4,
            'employeeId' => 2,
            'dayId' => 2,
            'dayName' => 'Selasa',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_employee')->insert([
            'id' => 5,
            'employeeId' => 2,
            'dayId' => 3,
            'dayName' => 'Rabu',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_employee')->insert([
            'id' => 6,
            'employeeId' => 2,
            'dayId' => 4,
            'dayName' => 'Kamis',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
