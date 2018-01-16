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
            'choice' => $request->input('choice'),
            'total' => null,
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

      $target = [];
      $data = Cart::content()->groupBy('options.shop_name');

      foreach ($data as $key => $value) {
      $sum = [];
        foreach ($value as $item) {
          $sum[] = $item->price * $item->qty;
          $item->subtotal = array_sum($sum);
        }
        //$item = array_add($value, 'total' , null);
        $target[$key] = $value;
      }
      return response()->json($target);
    }

    public function userCart()
    {
      return view('cart.mycart');
    }
    public function checkout()
    {
      return view('cart.checkout');
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
