<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_types')->insert([
            	//Men Apparel
                [
                    'name' => 'none',
                    'subcategory_id' => null,
                ],
                [
                    'name' => 'Shirts',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'T-shirts & Tanks',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Jackets',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Sweaters',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Suits',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Active',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Pants',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Shorts',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Jeans',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Underwear',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Socks',
                    'subcategory_id' => '1',
                ],
                [
                    'name' => 'Swim',
                    'subcategory_id' => '1',
                ],
                //Men's Shoes
                [
                    'name' => 'Athletic',
                    'subcategory_id' => '2',
                ],
                [
                    'name' => 'Fashion Sneakers',
                    'subcategory_id' => '2',
                ],
                [
                    'name' => 'Boots',
                    'subcategory_id' => '2',
                ],
                [
                    'name' => 'Loafters & Slip-ons',
                    'subcategory_id' => '2',
                ],
                [
                    'name' => 'Oxfords',
                    'subcategory_id' => '2',
                ],
                [
                    'name' => 'Sandals & Slippers',
                    'subcategory_id' => '2',
                ],
                //Men's Accessories
                [
                    'name' => 'Sunglasses & Eyewear',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Hats',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Belts',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Jewelry',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Watches',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Ties',
                    'subcategory_id' => '3',
                ],
                [
                    'name' => 'Others',
                    'subcategory_id' => '3',
                ],
                //Women Apparel
                [
                    'name' => 'Dresses',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'T-shirts & Tops',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Sweaters',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Suits & Blazers',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Active',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Pants',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Shorts',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Jeans',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Skirts',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Leggings',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Underwear',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Swim',
                    'subcategory_id' => '4',
                ],
                [
                    'name' => 'Socks',
                    'subcategory_id' => '4',
                ],
                //Women's Shoes
                [
                    'name' => 'Athletic',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Fashion Sneakers',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Boots',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Flats',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Pumps',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Loafters & Slip-ons',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Oxfords',
                    'subcategory_id' => '5',
                ],
                [
                    'name' => 'Sandals & Slippers',
                    'subcategory_id' => '5',
                ],
                //Women's Accessories
                [
                    'name' => 'Sunglasses & Eyewear',
                    'subcategory_id' => '6',
                ],
                [
                    'name' => 'Hats',
                    'subcategory_id' => '6',
                ],
                [
                    'name' => 'Belts',
                    'subcategory_id' => '6',
                ],
                [
                    'name' => 'Jewelry',
                    'subcategory_id' => '6',
                ],
                [
                    'name' => 'Watches',
                    'subcategory_id' => '6',
                ],
                [
                    'name' => 'Others',
                    'subcategory_id' => '6',
                ],
                //Men's Bag
                [
                    'name' => 'Bags',
                    'subcategory_id' => '7',
                ],
                [
                    'name' => 'Wallets',
                    'subcategory_id' => '7',
                ],
                //Women's Bag
                [
                    'name' => 'Handbags',
                    'subcategory_id' => '8',
                ],
                [
                    'name' => 'Wallets',
                    'subcategory_id' => '8',
                ],
                [
                    'name' => 'Other Bags',
                    'subcategory_id' => '8',
                ],
                //Luggage
                [
                    'name' => 'Luggage',
                    'subcategory_id' => '9',
                ],
                [
                    'name' => 'Travel Accessories',
                    'subcategory_id' => '9',
                ],
                //Cosmetics face
                [
                    'name' => 'Powder',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'Blushes',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'BB & CC Cream',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'Foundation',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'Primers',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'Bronzers & Highlighters',
                    'subcategory_id' => '10',
                ],
                [
                    'name' => 'Concealers & Neutralizers',
                    'subcategory_id' => '10',
                ],
                //Cosmetics eye
                [
                    'name' => 'Mascara',
                    'subcategory_id' => '11',
                ],
                [
                    'name' => 'Eye Liner',
                    'subcategory_id' => '11',
                ],
               	[
                    'name' => 'Eye Shadow',
                    'subcategory_id' => '11',
                ],
                [
                    'name' => 'Eye Lash',
                    'subcategory_id' => '11',
                ],
                [
                    'name' => 'Eyebrow',
                    'subcategory_id' => '11',
                ],
                //Cosmetics lips
                [
                    'name' => 'Lipstick',
                    'subcategory_id' => '12',
                ],
                [
                    'name' => 'Liquid Lipstick',
                    'subcategory_id' => '12',
                ],
                [
                    'name' => 'Lip Glosses',
                    'subcategory_id' => '12',
                ],
                [
                    'name' => 'Lip Liners',
                    'subcategory_id' => '12',
                ],
                [
                    'name' => 'Lip Tints',
                    'subcategory_id' => '12',
                ],
                [
                    'name' => 'Lip Plumpers',
                    'subcategory_id' => '12',
                ],
                //Nails
                [
                    'name' => 'Nail Polish',
                    'subcategory_id' => '13',
                ],
                [
                    'name' => 'Nail Polish Remover',
                    'subcategory_id' => '13',
                ],
                [
                    'name' => 'False Nails & Accessories',
                    'subcategory_id' => '13',
                ],
                //Tools
                [
                    'name' => 'Face',
                    'subcategory_id' => '16',
                ],
                [
                    'name' => 'Eye',
                    'subcategory_id' => '16',
                ],
                [
                    'name' => 'Nail',
                    'subcategory_id' => '16',
                ],
                //Skincare Face
                [
                    'name' => 'Facial Cleansing Products',
                    'subcategory_id' => '17',
                ],
                [
                    'name' => 'Facial Treatments & Masks',
                    'subcategory_id' => '17',
                ],
                [
                    'name' => 'Facial Creams & Moisturizers',
                    'subcategory_id' => '17',
                ],
                [
                    'name' => 'Facial Toners',
                    'subcategory_id' => '17',
                ],
                [
                    'name' => 'Facial Exfoliators',
                    'subcategory_id' => '17',
                ],
                //Skincare Body
                [
                    'name' => 'Sunscreen',
                    'subcategory_id' => '19',
                ],
                [
                    'name' => 'Body Moisturizers & Treatments',
                    'subcategory_id' => '19',
                ],
                //Skincare Fragrance
                [
                    'name' => 'Men',
                    'subcategory_id' => '20',
                ],
                [
                    'name' => 'Women',
                    'subcategory_id' => '20',
                ],

                //Hair styling
                [
                    'name' => 'Hair Color',
                    'subcategory_id' => '21',
                ],
                [
                    'name' => 'Hair Spray',
                    'subcategory_id' => '21',
                ],
                [
                    'name' => 'Hair Wax',
                    'subcategory_id' => '21',
                ],
                [
                    'name' => 'Pomade',
                    'subcategory_id' => '21',
                ],
                [
                    'name' => 'Hair Mousse',
                    'subcategory_id' => '21',
                ],
                [
                    'name' => 'Hair Gel',
                    'subcategory_id' => '21',
                ],
                //Hair care
                [
                    'name' => 'Hair Treatment',
                    'subcategory_id' => '22',
                ],
                [
                    'name' => 'Shampoo',
                    'subcategory_id' => '22',
                ],
                [
                    'name' => 'Conditioner',
                    'subcategory_id' => '22',
                ],
                //Hair Tools
                [
                    'name' => 'Tools & More',
                    'subcategory_id' => '23',
                ],
                [
                    'name' => 'Wigs & Extensions',
                    'subcategory_id' => '23',
                ],
                [
                    'name' => 'Combs & Brushes',
                    'subcategory_id' => '23',
                ],
                //Bath & Body
                [
                    'name' => 'Soaps & Shower Gels',
                    'subcategory_id' => '24',
                ],
                [
                    'name' => 'Moisturizers',
                    'subcategory_id' => '24',
                ],
                [
                    'name' => 'Scrubs',
                    'subcategory_id' => '24',
                ],
                [
                    'name' => 'Deodorants',
                    'subcategory_id' => '24',
                ],
                [
                    'name' => 'Hair Removal',
                    'subcategory_id' => '24',
                ],
        ]);
    }
}
