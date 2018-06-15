<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Auth;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class ShippingController extends Controller
{
  public function index()
  {
    $shipping = Auth::user()->shop->shipping ? Auth::user()->shop->shipping : 'undefined';

    return view('shop.settings.shipping', ['shipping' => $shipping]);
  }

  public function update(Request $request)
  {
    $shop = Auth::user()->shop;
    $updated = $shop->update([
      'shipping' => json_encode($request->shipping)
    ]);

    return response()->json($updated);
  }

}
