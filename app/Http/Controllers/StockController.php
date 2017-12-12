<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\Product;

class StockController extends Controller
{
    public function index(Request $request)
    {

      $products = $request->user()->products()->latestFirst()->get();

      return view('product.stock',[
        'products' => $products
      ]);
    }

    public function getProduct(Request $request)
    {
      $products = $request->user()->products()->latestFirst()->get();

      foreach ($products as $item) {
        $product = $item;
      }

      return response()->json($products);
    }

    public function setAmount(Product $product, Request $request)
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
