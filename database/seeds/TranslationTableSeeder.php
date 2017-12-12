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
                	'name' => 'ผู้ชาย'
                ],
                [
                	'category_id' => '2',
                	'language' => 'th',
                	'name' => 'ผู้หญิง'
                ],
                [
                	'category_id' => '3',
                	'language' => 'th',
                	'name' => 'กระเป๋า'
                ],
                [
                	'category_id' => '4',
                	'language' => 'th',
                	'name' => 'เครื่องสำอาง'
                ],
                [
                	'category_id' => '5',
                	'language' => 'th',
                	'name' => 'ดูแลผิว'
                ],
                [
                	'category_id' => '6',
                	'language' => 'th',
                	'name' => 'ผลิตภัณฑ์เกี่ยวกับเส้นผม'
                ],
                [
                	'category_id' => '7',
                	'language' => 'th',
                	'name' => 'ของใช้ส่วนตัว'
                ],

        ]);
    }
}
