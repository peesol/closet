<?php

use Illuminate\Database\Seeder;

class TranslationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_translation')->insert([
                [
                	'category_id' => '1',
                	'language' => 'th',
                	'name' => 'ผู้ชาย',
                  'slug' => 'men'
                ],
                [
                	'category_id' => '2',
                	'language' => 'th',
                	'name' => 'ผู้หญิง',
                  'slug' => 'women'
                ],
                [
                	'category_id' => '3',
                	'language' => 'th',
                	'name' => 'กระเป๋า',
                  'slug' => 'bags_luggage'
                ],
                [
                	'category_id' => '4',
                	'language' => 'th',
                	'name' => 'เครื่องสำอาง',
                  'slug' => 'cosmetics'
                ],
                [
                	'category_id' => '5',
                	'language' => 'th',
                	'name' => 'ดูแลผิว',
                  'slug' => 'skincare'
                ],
                [
                	'category_id' => '6',
                	'language' => 'th',
                	'name' => 'ผลิตภัณฑ์เกี่ยวกับเส้นผม',
                  'slug' => 'hair'
                ],
                [
                	'category_id' => '7',
                	'language' => 'th',
                	'name' => 'ของใช้ส่วนตัว',
                  'slug' => 'personal_care'
                ],
                [
                	'category_id' => '8',
                	'language' => 'th',
                	'name' => 'อาหารเสริม',
                  'slug' => 'personal_care'
                ],

        ]);
    }
}
