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
    $shipping = Auth::user()->shop->shipping ? Auth::user()->shop->shipping : json_encode([]);
    $days = Auth::user()->shop->shipping_date ? Auth::user()->shop->shipping_date : json_encode([]);
    return view('shop.settings.shipping', [
      'shipping' => $shipping,
      'days' => $days
    ]);
  }

  public function update(Request $request)
  {
    Auth::user()->shop->update([
      'shipping' => json_encode($request->methods),
      'shipping_date' => json_encode($request->days)
    ]);
    return ;
  }

}
