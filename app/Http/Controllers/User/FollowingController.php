<?php

namespace Closet\Http\Controllers\User;

use Fractal;
use Closet\Models\User;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class FollowingController extends Controller
{
  public function index(Request $request)
  {
    $shop = $request->user()->followedShops()->get();
          return view('following', [
              'followingShop' => $shop,
          ]);
  }

  public function following(Request $request)
  {
      return response()->json(
    Fractal::collection($request->user()->followedShops()->get())
          ->transformWith(new FollowingTransformer)
          ->toArray()
          );
  }

  public function unfollow(Request $request)
  {
    $request->user()->follows()->where('shop_id', $request->shop_id)->delete();

    return redirect()->back();
  }
}
