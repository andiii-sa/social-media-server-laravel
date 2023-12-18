<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog_category')->insert([
            'id' => 1,
            'name' => 'cat 1',
        ]);
        DB::table('blog_category')->insert([
            'id' => 2,
            'name' => 'cat 2',
        ]);
        DB::table('blog_category')->insert([
            'id' => 3,
            'name' => 'cat 3',
        ]);
        DB::table('blog_category')->insert([
            'id' => 4,
            'name' => 'cat 4',
        ]);
        DB::table('blog_category')->insert([
            'id' => 5,
            'name' => 'cat 5',
        ]);
        DB::table('blog_category')->insert([
            'id' => 6,
            'name' => 'cat 6',
        ]);
    }
}
