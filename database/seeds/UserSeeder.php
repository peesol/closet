<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      factory(Closet\Models\User::class, 10)->create()->each(function($user) {
        $user->shop()->save(factory(Closet\Models\Shop::class)->make() );
      });
      $this->call(ProductSeeder::class);
    }
}
