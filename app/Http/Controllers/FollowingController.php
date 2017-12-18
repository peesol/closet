<?php

namespace Closet\Http\Controllers;

use Illuminate\Http\Request;
use Closet\Models\User;
use Closet\Repositories\UserRepository;
use Closet\Transformer\FollowingTransformer;
use Fractal;

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

}
