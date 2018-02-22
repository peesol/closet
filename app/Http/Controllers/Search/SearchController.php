<?php

namespace Closet\Http\Controllers\Search;

use Cache;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Product, Category, Subcategory, CategoryType};

class SearchController extends Controller
{
  public function index(Request $request, Category $category, Subcategory $subcategory, CategoryType $type)
  {
      if(!$request->p){
         return redirect('/');
      }
      $categories = Cache::get('categories');
      $keyword = $request->query('p');
      $products = Product::search($request->query('p') , function ($algolia, $query, $options) use ($request) {
        if ($request->query('c')) {
          $options = [
            'filters' => 'category_id=' . $request->query('c')
          ];
        }
        if ($request->query('sub') && $request->query('c')) {
          $options = [
            'filters' => '( category_id='. $request->query('c') . ') AND subcategory_id='. $request->query('sub')
          ];
        }
        return $algolia->search($query, $options);

      })->paginate(20);

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
  public function productResult(Request $request)
  {
    $keyword = $request->query('p');
    $products = Product::where('name', 'LIKE', "%$keyword%")->filter($request)->get();

    return response()->json($products);
  }
}
