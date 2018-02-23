<?php

namespace Closet\Http\Controllers\Search;

use Cache;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Product, Category, Subcategory, CategoryType};

class SearchController extends Controller
{
  public function index(Request $request)
  {
      if(!$request->p){
         return redirect('/');
      }

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

      return view('search.result', [
        'products' => $products,
        'keyword' => $keyword,
        ]);
  }
  public function productResult(Request $request)
  {
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

    return response()->json($products);
  }
}
