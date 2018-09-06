<?php

namespace Closet\Http\Controllers\Shop;

use Closet\Models\Shop;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class FollowController extends Controller
{
  public function show(Request $request,Shop $shop)
  {
    $response = [
      'count' => $shop->followCount(),
      'user_followed' => false,
      'can_follow' => false,
    ];

    if ($request->user()) {
      $response = array_merge($response, [
        'user_followed' => $request->user()->isFollow($shop),
        'can_follow' => !$request->user()->ownsShop($shop)
        ]);
    }

    return response()->json([
      'data' => $response
      ], 200);
  }

  public function create(Request $request,Shop $shop)
  {
    $request->user()->follows()->create([
        'shop_id' => $shop->id
      ]);
    return response()->json(null, 200);
  }

  public function delete(Request $request,Shop $shop)
  {
    $request->user()->follows()->where('shop_id', $shop->id)->delete();
    return response()->json(null, 200);
  }
}
