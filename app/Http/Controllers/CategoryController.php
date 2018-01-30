<?php

namespace Closet\Http\Controllers;

use App;
use Cache;
use Illuminate\Http\Request;
use Closet\Models\Category;

class CategoryController extends Controller
{
    public function main()
    {
      $categories = Cache::rememberForever('categories', function() {
        return Category::all();
      });

    	return view('category.main')->with([
    		'categories' => $categories,
    		]);
    }

    public function category(Category $category)
    {
        $categories = Cache::rememberForever('categories', function() {
          return Category::all();
        });
        $subcategories = Cache::rememberForever('subcategories', function() {
          return $category->subcategory()->get();
        });

      return view('category.category',[
        'category' => $category,
        'categories' => $categories,
        'subcategories' => $subcategories,
        ]);
    }

}
