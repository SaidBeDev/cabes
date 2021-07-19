<?php

use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'name' => "Mathématiques"
        ]);

        DB::table('modules')->insert([
            'name' => "Physique"
        ]);

        DB::table('modules')->insert([
            'name' => "Science"
        ]);

        DB::table('modules')->insert([
            'name' => "Français"
        ]);

        DB::table('modules')->insert([
            'name' => "Anglais"
        ]);
    }
}
