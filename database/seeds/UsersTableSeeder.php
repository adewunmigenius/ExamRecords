<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Exam Admin',
            'email' => 'admin@exam.com',
            'email_verified_at' => '2019-03-27 10:35:25',
            'type' => 2,
            'password' => bcrypt('secret'),
        ]);
    }
}
