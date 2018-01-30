<?php

namespace Closet\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use Closet\Models\{Category,Subcategory,CategoryType};

class CacheCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cache all categories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      Cache::rememberForever('categories', function() {
        return Category::all();
      });
      Cache::rememberForever('subcategories', function() {
        return Subcategory::all();
      });
      Cache::rememberForever('types', function() {
        return CategoryType::all();
      });

        // Cache::forever('categories', $categories);
        // Cache::forever('subcategories', $subcategories);
        // Cache::forever('types', $types);
        $this->info('Done caching all categories');
    }
}
