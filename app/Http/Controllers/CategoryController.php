<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\Category;

class CategoryController extends Controller
{
    public function main()
    {
    	$category = Category::all();

    	return view('category.main')->with([

    		'categories' => $category

    		]);
    }

    public function category(Category $category)
    {
        $categories = Category::all();
        $subcategories = $category->subcategory()->get();

      return view('category.category',[

        'category' => $category,
        'categories' => $categories,
        'subcategories' => $subcategories

        ]);
    }

}
