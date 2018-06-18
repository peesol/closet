<?php

namespace Closet\Http\Controllers\Cart;

use Cart;
use Fractal;
use Illuminate\Http\Request;
use Closet\Models\Product;
use Closet\Http\Controllers\Controller;
use Closet\Transformer\CartProductTransformer;

class CartController extends Controller
{
  public function addToCart(Request $request)
  {
    $price = $request->input('product.discount_price') ? $request->input('product.discount_price') : $request->input('product.price');
    Cart::add([
      'id' => $request->input('product.id'),
      'name' => $request->input('product.name'),
      'price' => $price,
      'qty' => 1,
      'options' => [
          'shop_name' => $request->input('product.shop_name'),
          'shop_id' => $request->input('product.shop_id'),
          'choice' => $request->input('choice'),
          'shipping' => $request->input('shipping'),
          'stock' => $request->input('stock'),
        ]
    ]);

    return ;
  }
  public function getProduct(Product $product)
  {
    return response()->json( Fractal::item($product, new CartProductTransformer) );
  }
  public function getCart()
  {
    $data = Cart::content()->toArray();

    return response()->json(array_values($data));
  }

  public function getCartByShop()
  {
    $target = [];
    $data = Cart::content()->groupBy('options.shop_name');

    foreach ($data as $key => $value) {
      $target[$key] = $value;
    }
    return response()->json($target);
  }

  public function userCart()
  {
    return view('cart.mycart');
  }

  public function updateQty(Request $request)
  {
    $rowId = $request->rowId;
    $qty = (int)$request->qty;
    if($qty >= 1){
      $data = Cart::update($rowId, ['qty' => $qty]);
      return response($data);
    } else {
      return;
    }
  }

  public function removeProduct(Request $request, $rowId)
  {
    return Cart::remove($rowId);
  }
}
