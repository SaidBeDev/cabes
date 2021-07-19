<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profile_types')->insert([
            'name' => "admin"
        ]);
        DB::table('profile_types')->insert([
            'name' => "teacher"
        ]);
        DB::table('profile_types')->insert([
            'name' => "student"
        ]);
    }
}
