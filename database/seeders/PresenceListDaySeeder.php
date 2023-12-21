<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PresenceListDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presence_list_day')->insert([
            'id' => 1,
            'name' => 'Senin',
            'sequence' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 2,
            'name' => 'Selasa',
            'sequence' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 3,
            'name' => 'Rabu',
            'sequence' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 4,
            'name' => 'Kamis',
            'sequence' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 5,
            'name' => 'Jum`at',
            'sequence' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 6,
            'name' => 'Sabtu',
            'sequence' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('presence_list_day')->insert([
            'id' => 7,
            'name' => 'Minggu',
            'sequence' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
