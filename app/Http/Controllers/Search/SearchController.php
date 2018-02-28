<?php

namespace Closet\Http\Controllers\Search;

use Cache;
use Illuminate\Http\Request;
use Closet\Http\Resources\ProductResource;
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
      $products = Product::search($request->query('p'))->paginate(20);

      return view('search.index', [
        'products' => $products,
        'keyword' => $keyword,
        ]);
  }
  public function productResult(Request $request)
  {
    $keyword = $request->query('p');
    $products = Product::search($request->query('p') , function ($algolia, $query, $options) use ($request) {
      $page = $request->query('page') ? $request->query('page') : null;
      if ($request->query('c')) {
        $options = [
          'page' => $request->query('page'),
          'filters' => '( category_id=' . $request->query('c') . ') AND price=' . $request->query('min')
        ];
      }
      if ($request->query('sub') && $request->query('c')) {
        $options = [
          'page' => $request->query('page'),
          'filters' => '( category_id='. $request->query('c') . ') AND subcategory_id='. $request->query('sub')
        ];
      }
      if ($request->query('sub') && $request->query('type')) {
        $options = [
          'page' => $request->query('page'),
          'filters' => '( category_id='. $request->query('c') . ') AND ( subcategory_id='. $request->query('sub') . ') AND  type_id='. $request->query('type')
        ];
      }
      return $algolia->search($query, $options);

    })->paginate(20);
    // return response($products);
    return new ProductResource($products);
  }
}
