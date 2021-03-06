<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            'fullname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'isAdmin' => 1,
            'is_logged_in' => 1
        ]);
    }
}
