<?php

namespace Closet\Http\Controllers\Shop\Settings;

use DB;
use Auth;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class ShippingController extends Controller
{
  public function index()
  {
    $shipping = Auth::user()->shop->shipping;
    return view('shop.settings.shipping', ['shipping' => $shipping]);
  }

  public function update(Request $request)
  {
    Auth::user()->shop->shipping->update([
      'shipping_methods' => $request->methods,
      'shipping_date' => $request->days
    ]);
    return ;
  }

}
