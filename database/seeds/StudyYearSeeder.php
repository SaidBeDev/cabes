<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudyYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('study_years')->insert([
            'name' => "5e année primaire"
        ]);

        // Moyenne
        DB::table('study_years')->insert([
            'name' => "1ère année moyenne"
        ]);

        DB::table('study_years')->insert([
            'name' => "2e année moyenne"
        ]);

        DB::table('study_years')->insert([
            'name' => "3e année moyenne"
        ]);

        DB::table('study_years')->insert([
            'name' => "4e année moyenne (BEM)"
        ]);

        // Secondaire
        DB::table('study_years')->insert([
            'name' => "1ére année secondaire"
        ]);

        DB::table('study_years')->insert([
            'name' => "2e année secondaire"
        ]);

        DB::table('study_years')->insert([
            'name' => "3e année secondaire (BAC)"
        ]);

    }
}
