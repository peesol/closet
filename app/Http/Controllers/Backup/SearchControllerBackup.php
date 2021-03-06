<?php
/*
|--------------------------------------------------------------------------
| This is the original search Controller that doesn't use algolia
| to search the database
|
|--------------------------------------------------------------------------
*/

namespace Closet\Http\Controllers;

use Cache;
use Illuminate\Http\Request;
use Closet\Models\Product;
use Closet\Models\Category;
use Closet\Models\Subcategory;
use Closet\Models\CategoryType;

class SearchController extends Controller
{
    public function searchByProduct($keyword){

        $products  = Product::where('name', 'LIKE', "%$keyword%")->where('visibility','public')->distinct()->get(['name']);
        return response()->json($products);
    }

    public function index(Request $request, Category $category, Subcategory $subcategory, CategoryType $type)
    {
    	  if(!$request->p){
    		   return redirect('/');
    	  }
        $categories = Cache::get('categories');
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
      $categories = Cache::get('categories');

      return response()->json($categories);
    }

    public function productResult(Request $request)
    {
      $keyword = $request->query('p');
      $products = Product::where('name', 'LIKE', "%$keyword%")->filter($request)->get();

      return response()->json($products);
    }
}
