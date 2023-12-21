<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PresenceScheduleEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presence_schedule_employee')->insert([
            'id' => 1,
            'employeeId' => 1,
            'dayId' => 1,
            'locationWorkId' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_schedule_employee')->insert([
            'id' => 2,
            'employeeId' => 1,
            'dayId' => 2,
            'locationWorkId' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_schedule_employee')->insert([
            'id' => 3,
            'employeeId' => 2,
            'dayId' => 1,
            'locationWorkId' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_schedule_employee')->insert([
            'id' => 4,
            'employeeId' => 2,
            'dayId' => 2,
            'locationWorkId' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_schedule_employee')->insert([
            'id' => 5,
            'employeeId' => 2,
            'dayId' => 3,
            'locationWorkId' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_schedule_employee')->insert([
            'id' => 6,
            'employeeId' => 2,
            'dayId' => 4,
            'locationWorkId' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
