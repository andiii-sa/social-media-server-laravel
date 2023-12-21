<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PresenceLocationWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presence_location_work')->insert([
            'id' => 1,
            'name' => 'WFA',
            'clockIn' => '08:00:00',
            'clockOut' => '17:00:00',
            'isRequiredLocation' => true,
            'isRequiredPhoto' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_location_work')->insert([
            'id' => 2,
            'name' => 'ONSITE',
            'clockIn' => '09:00:00',
            'clockOut' => '18:00:00',
            'isRequiredLocation' => false,
            'isRequiredPhoto' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_location_work')->insert([
            'id' => 3,
            'name' => 'ONSITE 2',
            'clockIn' => '09:00:00',
            'clockOut' => '18:00:00',
            'isRequiredLocation' => false,
            'isRequiredPhoto' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_location_work')->insert([
            'id' => 4,
            'name' => 'ONSITE 3',
            'clockIn' => '09:00:00',
            'clockOut' => '18:00:00',
            'isRequiredLocation' => false,
            'isRequiredPhoto' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_location_work')->insert([
            'id' => 5,
            'name' => 'ONSITE 4',
            'clockIn' => '09:00:00',
            'clockOut' => '18:00:00',
            'isRequiredLocation' => false,
            'isRequiredPhoto' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_location_work')->insert([
            'id' => 6,
            'name' => 'ONSITE 5',
            'clockIn' => '09:00:00',
            'clockOut' => '18:00:00',
            'isRequiredLocation' => false,
            'isRequiredPhoto' => false,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
