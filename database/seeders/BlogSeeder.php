<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blog')->insert([
            'id' => 1,
            'blogCategoryId' => 1,
            'authorId' => 2,
            'title' => 'blog 1',
            'image' => 'https://images.unsplash.com/photo-1682685797527-63b4e495938f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'body' => 'haii 1',
        ]);
        DB::table('blog')->insert([
            'id' => 2,
            'blogCategoryId' => 1,
            'authorId' => 2,
            'title' => 'blog 2',
            'image' => 'https://images.unsplash.com/photo-1682685797527-63b4e495938f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'body' => 'haii 2',
        ]);
        DB::table('blog')->insert([
            'id' => 3,
            'blogCategoryId' => 2,
            'authorId' => 1,
            'title' => 'blog 3',
            'image' => 'https://images.unsplash.com/photo-1682685797527-63b4e495938f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'body' => 'haii 3',
        ]);
        DB::table('blog')->insert([
            'id' => 4,
            'blogCategoryId' => 2,
            'authorId' => 1,
            'title' => 'blog 4',
            'image' => 'https://images.unsplash.com/photo-1682685797527-63b4e495938f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'body' => 'haii 4',
        ]);
        DB::table('blog')->insert([
            'id' => 5,
            'blogCategoryId' => 2,
            'authorId' => 1,
            'title' => 'blog 5',
            'image' => 'https://images.unsplash.com/photo-1682685797527-63b4e495938f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'body' => 'haii 5',
        ]);
    }
}
