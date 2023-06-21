<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'user_id' => 1,
            'post_id' => 2,
            'body' => 'ユーザー１がユーザー２に対してのコメント',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
        DB::table('comments')->insert([
            'user_id' => 2,
            'post_id' => 1,
            'body' => 'ユーザー２がユーザー１に対してのコメント',
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
