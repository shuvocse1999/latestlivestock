<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('users')->insert([
            'name'      => "Super Admin",
            'email'     =>'admin@gmail.com',
            'password'  => Hash::make('12345678'),
            'set_password' => "12345678",
        ]);
    }
}
