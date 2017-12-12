<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypeTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubcategoriesTableSeeder::class);
        $this->call(TypeTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(TranslationTableSeeder::class);
        $this->call(SubcategoriesTranslationTableSeeder::class);
        $this->call(TypeTranslationTableSeeder::class);
    }
}
