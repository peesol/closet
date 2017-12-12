<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([

                ['name' => 'Men','slug' => 'men'],
                ['name' => 'Women','slug' => 'women'],
                ['name' => 'Luggage & Bags','slug' => 'bags_luggage'],
                ['name' => 'Cosmetics','slug' => 'cosmetics'],
                ['name' => 'Skincare','slug' => 'skincare'],
                ['name' => 'Hair Products','slug' => 'hair'],
                ['name' => 'Personal Care','slug' => 'personal_care'],

                ]);
    }
}
