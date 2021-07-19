<?php

use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contact_types')->insert([
            'name' => 'facebook',
        ]);

        DB::table('contact_types')->insert([
            'name' => 'twitter',
        ]);

        DB::table('contact_types')->insert([
            'name' => 'linkedin',
        ]);

        DB::table('contact_types')->insert([
            'name' => 'instagram',
        ]);

        DB::table('contact_types')->insert([
            'name' => 'viber',
        ]);

        DB::table('contact_types')->insert([
            'name' => 'whatsapp',
        ]);

    }
}
