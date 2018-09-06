<?php

namespace Closet\Http\Controllers\Product\User;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class MyProductController extends Controller
{
  public function getProduct(Request $request)
  {
    $products = $request->user()->products()->latestFirst()->get();

    return response()->json($products);
  }
  public function myproductPage(Request $request)
  {
    $products = $request->user()->products()->latestFirst()->paginate(20);

    return view('product.myproduct', ['products' => $products]);
  }
  public function myUsedProductPage(Request $request)
  {
    $products = $request->user()->used()->latestFirst()->paginate(20);

    return view('product.myproduct_used', ['products' => $products]);
  }
}
