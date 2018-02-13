<?php

namespace Closet\Http\Controllers\Product\Shipping;

use Closet\Models\Product;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class ShippingController extends Controller
{
  public function index(Request $request)
  {
    $shop = $request->user()->shop;

    return view('product.settings.shipping', [
      'shop' => $shop
    ]);
  }
  /*
  |--------------------------------------------------------------------------
  | This will update all of shop's products
  |--------------------------------------------------------------------------
  */
  public function updateAll(Request $request)
  {
    $products = Product::where('shop_id', $request->user()->shop->id);

    $products->update([
      'shipping' => $request->shipping,
      'shipping_free' => $request->shipping_free,
      'shipping_fee' => $request->shipping_fee,
      'shipping_time' => $request->shipping_time,
      'shipping_inter' => $request->shipping_inter,
    ]);

    return response()->json(null, 200);
  }

  public function updateByProduct(Request $request, Product $product)
  {
    $this->authorize('update', $product);

    $product->update([
      'shipping' => $request->shipping,
      'shipping_free' => $request->shipping_free,
      'shipping_fee' => $request->shipping_fee,
      'shipping_time' => $request->shipping_time,
      'shipping_inter' => $request->shipping_inter,
    ]);
    return response()->json(null, 200);
  }
}
