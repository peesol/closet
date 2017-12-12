<?php

use Illuminate\Database\Seeder;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            DB::table('subcategories')->insert([
                //Men
                [
                    'name' => 'Clothing',
                    'slug' => 'clothing',
                    'category_id' => '1',
                ],
                [
                    'name' => 'Shoes',
                    'slug' => 'shoes',
                    'category_id' => '1',
                ],
                [
                    'name' => 'Accessories',
                    'slug' => 'accessories',
                    'category_id' => '1',
                ],
                //Women
                [
                    'name' => 'Clothing',
                    'slug' => 'clothing',
                    'category_id' => '2',
                ],
                [
                    'name' => 'Shoes',
                    'slug' => 'shoes',
                    'category_id' => '2',
                ],
                [
                    'name' => 'Accessories',
                    'slug' => 'accessories',
                    'category_id' => '2',
                ],
                //Luggage & Bags
                [
                    'name' => 'Men',
                    'slug' => 'men',
                    'category_id' => '3',
                ],
                [
                    'name' => 'Women',
                    'slug' => 'women',
                    'category_id' => '3',
                ],
                [
                    'name' => 'Luggage',
                    'slug' => 'luggage',
                    'category_id' => '3',
                ],
                //Cosmetics
                [
                    'name' => 'Face',
                    'slug' => 'face',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Eyes',
                    'slug' => 'eyes',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Lips',
                    'slug' => 'lips',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Nails',
                    'slug' => 'nails',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Makeup Sets & Palettes',
                    'slug' => 'sets',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Makeup Remover',
                    'slug' => 'makeup_remover',
                    'category_id' => '4',
                ],
                [
                    'name' => 'Tools & Brushes',
                    'slug' => 'tools',
                    'category_id' => '4',
                ],
                //Skincare
                [
                    'name' => 'Face',
                    'slug' => 'face',
                    'category_id' => '5',
                ],
                [
                    'name' => 'Eyes',
                    'slug' => 'eyes',
                    'category_id' => '5',
                ],
                [
                    'name' => 'Body',
                    'slug' => 'body',
                    'category_id' => '5',
                ],
                [
                    'name' => 'Fragrance',
                    'slug' => 'fragrance',
                    'category_id' => '5',
                ],
                //Hair
                [
                    'name' => 'Hair Styling',
                    'slug' => 'styling',
                    'category_id' => '6',
                ],
                [
                    'name' => 'Hair Care',
                    'slug' => 'care',
                    'category_id' => '6',
                ],
                [
                    'name' => 'Hair Tools',
                    'slug' => 'tools',
                    'category_id' => '6',
                ],
                //Personal Care
                [
                    'name' => 'Baths & Body',
                    'slug' => 'baths_body',
                    'category_id' => '7',
                ],
                [
                    'name' => 'Wipes & Cotton',
                    'slug' => 'wipes_cotton',
                    'category_id' => '7',
                ],
            ]);
    }
}
