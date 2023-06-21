<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user1',
            'email'=> 'user1@test.mail',
            'password' => Hash::make('abcdefgh'),
        ]);
        DB::table('users')->insert([
            'name' => 'user2',
            'email'=> 'user2@test.mail',
            'password' => Hash::make('abcdefgh'),
        ]);
    }
}
