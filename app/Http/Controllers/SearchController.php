<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\Product;
use Closet\Models\Category;
use Closet\Models\Subcategory;
use Closet\Models\CategoryType;

class SearchController extends Controller
{
   /* public function index()
    {
    	 $products = Product::get(array('product_name','uid'));

        return response()->json($products);
    }*/

    public function searchByProduct($keyword){

        $products  = Product::where('name', 'LIKE', "%$keyword%")->take(10)->get(array('name'));
        return response()->json($products);
    }

    public function index(Request $request, Category $category, Subcategory $subcategory, CategoryType $type)
    {
    	  if(!$request->p){
    		   return redirect('/');
    	  }
        $categories = Category::all();
    		$keyword = $request->input('p');
    		$products = Product::where('name', 'LIKE', "%$keyword%")->where('visibility','public')->filter($request)->paginate(20);

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

    public function getCategory(Category $category)
    {
      $categories = Category::all();

      return response()->json($categories);
    }

    public function productResult(Request $request)
    {
      $keyword = $request->query('p');
      $products = Product::where('name', 'LIKE', "%$keyword%")->filter($request)->get();

      return response()->json($products);
    }
}
