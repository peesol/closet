<?php

namespace Closet\Http\Controllers;

use Cart;
use Session;
use Fractal;
use Illuminate\Http\Request;
use Closet\Models\Product;
use Closet\Transformer\CartProductTransformer;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
      Cart::add([
        'id' => $request->input('product.id'),
        'name' => $request->input('product.name'),
        'price' => $request->input('product.price'),
        'qty' => 1,
        'options' => [
            'shop_name' => $request->input('product.shop_name'),
            'shop_id' => $request->input('product.shop_id'),
            'choice' => $request->input('choice')
          ]
      ]);

      return response()->json();
    }
    public function getProduct(Product $product)
    {

      return response()->json( Fractal::item($product, new CartProductTransformer) );
    }
    public function getCart()
    {
      //Cart::destroy();
      $data = Cart::content()->toArray();

      return response()->json(array_values($data));
    }

    public function getCartByShop()
    {
      $data = Cart::content()->groupBy('options.shop_name');

      return response()->json($data);
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
        return Cart::update($rowId, ['qty' => $qty]);
      } else {
        return;
      }
    }

    public function removeProduct(Request $request, $rowId)
    {
      return Cart::remove($rowId);
    }
}
