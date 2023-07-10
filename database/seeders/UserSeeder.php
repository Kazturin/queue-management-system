<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $user = DB::table('users')->insert([
            'name' => 'admin',
            'login' => 'admin',
            'password' => bcrypt('admin')
        ]);
       $user->assignRole('Admin');
    }
}
