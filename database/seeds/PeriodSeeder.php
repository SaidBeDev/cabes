<?php

use Illuminate\Database\Seeder;

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
            'hour_from' => "08:00",
            'hour_to' => "09:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "09:00",
            'hour_to' => "10:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "10:00",
            'hour_to' => "11:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "11:00",
            'hour_to' => "12:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "12:00",
            'hour_to' => "13:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "13:00",
            'hour_to' => "14:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "14:00",
            'hour_to' => "15:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "15:00",
            'hour_to' => "16:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "16:00",
            'hour_to' => "17:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "17:00",
            'hour_to' => "18:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "18:00",
            'hour_to' => "19:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "19:00",
            'hour_to' => "20:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "20:00",
            'hour_to' => "21:00",
            'nbr_hours' => "1",
        ]);

        DB::table('periods')->insert([
            'hour_from' => "21:00",
            'hour_to' => "22:00",
            'nbr_hours' => "1",
        ]);

    }
}
