<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
                'name'=> '環境構築について'
        ]);
        DB::table('categories')->insert([
                'name'=> 'Laravelドキュメントについて'
        ]);
        DB::table('categories')->insert([
                'name'=> 'エラーの発生について'
        ]);
    }
}
