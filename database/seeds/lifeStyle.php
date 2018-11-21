<?php

use Illuminate\Database\Seeder;

class lifeStyle extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->insert([
        ['name' => 'Life Style','slug' => 'life_style']
      ]);
      DB::table('subcategories')->insert([
        [
            'name' => 'Fabics',
            'slug' => 'fabrics',
            'category_id' => '9',
        ],
        [
            'name' => 'Stationary',
            'slug' => 'stationary',
            'category_id' => '9',
        ],
        [
            'name' => 'Others',
            'slug' => 'others',
            'category_id' => '9',
        ],
      ]);

      DB::table('category_translation')->insert([
        [
          'category_id' => '9',
          'language' => 'th',
          'name' => 'ไลฟ์สไตล์',
          'slug' => 'life_style'
        ]
    ]);
    DB::table('category_translation')->insert([
      [
        'subcategory_id' => '29',
        'language' => 'th',
        'name' => 'สิ่งทอ'
      ],
      [
        'subcategory_id' => '30',
        'language' => 'th',
        'name' => 'เครื่องเขียน'
      ],
      [
        'subcategory_id' => '31',
        'language' => 'th',
        'name' => 'อื่นๆ'
      ]
    ]);
    }
}
