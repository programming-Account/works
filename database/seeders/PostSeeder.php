<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'period_id' => 1,
            'body' => '最初の投稿',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'category_id' => 1,
            'period_id' => 1,
            'body' => '2個目の投稿',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
