<?php

use Closet\Models\User;
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
      $user = User::create([
          'name' => 'Closet Official',
          'email' => 'admin@closet.plus',
          'password' => bcrypt('ThisIsCloset2018'),
          'verified' => true,
          'email_token' => 'Master_Key',
          'address' => 'not specified',
          'phone' => 'not specified',
          'country' => 'th',
          'language' => 'th',
          'gender' => 'men',
      ]);

      $shop = $user->shop()->create([
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

      $shop->availablePromotions()->create([
        'discount' => 5,
        'get_another' => 5,
        'flash_sale' => 2,
      ]);
    }
}
