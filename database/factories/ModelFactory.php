<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Closet\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'email_token' => str_random(10),
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'country' => 'ไทย',
        'gender' => 'men',
    ];
});

$factory->define(Closet\Models\Shop::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->company,
        'slug' => uniqid('shop_'),
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'view_count' => $faker->numberBetween($min = 200, $max = 5000),
    ];

});

$factory->define(Closet\Models\Product::class, function (Faker\Generator $faker) {

    return [
        'shop_id' => $faker->numberBetween($min = 2, $max = 10),
        'category_id' => $faker->numberBetween($min = 1, $max = 7),
        'subcategory_id' => $faker->numberBetween($min = 1, $max = 25),
        'type_id' => $faker->numberBetween($min = 1, $max = 110),
        'uid' => uniqid('p_'),
        'name' => 'test_Product' . $faker->company,
        'price' => $faker->numberBetween($min = 500, $max = 9000),
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'thumbnail' => 'test.jpg',
        'visibility' => 'public',
        'view_count' => $faker->numberBetween($min = 200, $max = 5000),
    ];

});
