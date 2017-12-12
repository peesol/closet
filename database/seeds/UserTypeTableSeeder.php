<?php

use Illuminate\Database\Seeder;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usertypes')->insert([
                ['name' => 'Common'],
                ['name' => 'Verified'],
                ['name' => 'Official brand'],
                ['name' => 'Closet'],
        ]);
    }
}
