<?php

namespace Closet\Http\Controllers\Admin\Product;

use Closet\Models\Product;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class CompanyProductController extends Controller
{
  public function index()
  {
    $products = Product::where('shop_type', 99)->get();
    return view('admin.product.index', ['products' => $products]);
  }
}
