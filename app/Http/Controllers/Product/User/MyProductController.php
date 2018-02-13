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
}
