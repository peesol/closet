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
      $categories = Cache::get('categories');

    	return view('category.main')->with([
    		'categories' => $categories,
    		]);
    }

    public function category(Category $category)
    {
        $categories = Cache::get('categories');
        $subcategories = Cache::get('subcategories');

      return view('category.category',[
        'category' => $category,
        'categories' => $categories,
        'subcategories' => $category->subcategory,
        ]);
    }

}
