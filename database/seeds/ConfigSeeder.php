<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'name' => "hourly_price",
            'content' => '300'
        ]);

        DB::table('configs')->insert([
            'name' => "group_price",
            'content' => '300'
        ]);

        DB::table('configs')->insert([
            'name' => "session_cancel_penality",
            'content' => '10'
        ]);

        DB::table('configs')->insert([
            'name' => "session_percentage",
            'content' => '10'
        ]);

        DB::table('configs')->insert([
            'name' => "group_capacity",
            'content' => '15'
        ]);

    }
}
