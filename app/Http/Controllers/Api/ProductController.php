<?php

namespace Closet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\Product;
use Closet\Models\Category;
use Closet\Models\Subcategory;
use Closet\Models\CategoryType;

class ProductController extends Controller
{
  public function index(Request $request, Category $category, Subcategory $subcategory, CategoryType $type)
  {
      if(!$request->p){
         return redirect('/');
      }
      $categories = Category::all();
      $keyword = $request->input('p');
      $products = Product::where('name', 'LIKE', "%$keyword%")->filter($request)->get();

      if($request->query('c')){
        $id = $request->query('c');
        $subcategories = $subcategory->where('category_id', $id)->get();
      } else {
        $subcategories = [];
      }
      if($request->query('sub')){
        $id = $request->query('sub');
        $types = $type->where('subcategory_id', $id)->get();
      } else {
        $types = [];
      }

      return view('search.result', [
        'products' => $products,
        'keyword' => $keyword,
        'categories' => $categories,
        'subcategories' => $subcategories,
        'types' => $types,
        ]);
  }
}
