<?php

use Illuminate\Database\Seeder;

class SubcategoriesTranslationTableSeeder extends Seeder
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
        'subcategory_id' => '1',
        'language' => 'th',
        'name' => 'เสื้อผ้า'
      ],
      [
        'subcategory_id' => '2',
        'language' => 'th',
        'name' => 'รองเท้า'
      ],
      [
        'subcategory_id' => '3',
        'language' => 'th',
        'name' => 'เครื่องประดับ'
      ],
      [
        'subcategory_id' => '4',
        'language' => 'th',
        'name' => 'เสื้อผ้า'
      ],
      [
        'subcategory_id' => '5',
        'language' => 'th',
        'name' => 'รองเท้า'
      ],
      [
        'subcategory_id' => '6',
        'language' => 'th',
        'name' => 'เครื่องประดับ'
      ],
      [
        'subcategory_id' => '7',
        'language' => 'th',
        'name' => 'ผู้ชาย'
      ],
      [
        'subcategory_id' => '8',
        'language' => 'th',
        'name' => 'ผู้หญิง'
      ],
      [
        'subcategory_id' => '9',
        'language' => 'th',
        'name' => 'กระเป๋าเดินทาง'
      ],
      [
        'subcategory_id' => '10',
        'language' => 'th',
        'name' => 'เครื่องสำอางสำหรับใบหน้า'
      ],
      [
        'subcategory_id' => '11',
        'language' => 'th',
        'name' => 'เครื่องสำอางสำหรับดวงตา'
      ],
      [
        'subcategory_id' => '12',
        'language' => 'th',
        'name' => 'เครื่องสำอางสำหรับริมฝีปาก'
      ],
      [
        'subcategory_id' => '13',
        'language' => 'th',
        'name' => 'เครื่องสำอางสำหรับเล็บ'
      ],
      [
        'subcategory_id' => '14',
        'language' => 'th',
        'name' => 'ชุดเซ็ทเครื่องสำอาง & พาเลตต์'
      ],
      [
        'subcategory_id' => '15',
        'language' => 'th',
        'name' => 'ผลิตภัณฑ์ล้างเครื่องสำอาง'
      ],
      [
        'subcategory_id' => '16',
        'language' => 'th',
        'name' => 'อุปกรณ์แต่งหน้า'
      ],
      [
        'subcategory_id' => '17',
        'language' => 'th',
        'name' => 'ผลิตภัณฑ์ดูแลผิวหน้า'
      ],
      [
        'subcategory_id' => '18',
        'language' => 'th',
        'name' => 'ผลิตภัณฑ์ดูแลดวงตา'
      ],
      [
        'subcategory_id' => '19',
        'language' => 'th',
        'name' => 'ผลิตภัณฑ์ดูแลผิวกาย'
      ],
      [
        'subcategory_id' => '20',
        'language' => 'th',
        'name' => 'น้ำหอม'
      ],
      [
        'subcategory_id' => '21',
        'language' => 'th',
        'name' => 'จัดแต่งทรงผม'
      ],
      [
        'subcategory_id' => '22',
        'language' => 'th',
        'name' => 'บำรุง & ดูแลเส้นผม'
      ],
      [
        'subcategory_id' => '23',
        'language' => 'th',
        'name' => 'อุปกรณ์ทำผม'
      ],
      [
        'subcategory_id' => '24',
        'language' => 'th',
        'name' => 'อาบน้ำ & ดูแลผิวกาย'
      ],
      [
        'subcategory_id' => '25',
        'language' => 'th',
        'name' => 'กระดาษซับ สำลี & อื่นๆ'
      ],
    ]);
    }
}
