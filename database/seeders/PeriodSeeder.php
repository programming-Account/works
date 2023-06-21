<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('periods')->insert([
                'name'=> '3カ月未満'
        ]);
        DB::table('periods')->insert([
                'name'=> '6カ月未満'
        ]);
        DB::table('periods')->insert([
                'name'=> '1年以上'
        ]);
    }
}
