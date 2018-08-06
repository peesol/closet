<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
        'id' => 0,
        'name' => 'Closet Official',
        'email' => 'admin@closet.plus',
        'password' => bcrypt('ThisIsCloset2018'),
        'verified' => true,
        'can_sell' => false,
        'email_token' => 'Master_Key',
        'address' => 'not specified',
        'phone' => 'not specified',
        'country' => 'th',
        'gender' => 'men',
      ]);

      DB::table('shops')->insert([
        'id' => 0,
        'user_id' => 0,
        'usertype' => 99,
        'profile_type' => 1,
        'name' => 'Closet',
        'slug' => 'closet',
        'description' => 'not specified',
        'thumbnail' => 'closet_thumbnail.jpg',
        'cover' => 'closet_cover.jpg',
        'view_count' => 0,
        'shipping' => null,
      ]);

      DB::table('shop_promotions')->insert([
        'id' => 0,
        'shop_id' => 0,
        'discount' => 99,
        'get_another' => 99,
        'flash_sale' => 99,
      ]);
    }
}
