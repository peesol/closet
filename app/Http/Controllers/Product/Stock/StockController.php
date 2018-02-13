<?php

namespace Closet\Http\Controllers\Product\Stock;

use Closet\Models\Product;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class StockController extends Controller
{
  public function index(Request $request)
  {
    $products = $request->user()->products()->latestFirst()->get();

    return view('product.stock',[
      'products' => $products
    ]);
  }

  public function update(Product $product, Request $request)
  {
    $this->authorize('update', $product);

    if($request->amount >= 1){
      $product->update([
        'amount' => $request->amount,
        'stock' => true
      ]);
    } else {
      $product->update([
        'amount' => $request->amount,
        'stock' => false
      ]);
    }
    return response()->json(null, 200);
  }

}
