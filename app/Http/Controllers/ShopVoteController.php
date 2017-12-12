<?php

namespace Closet\Http\Controllers;

use Closet\Models\Shop;
use Closet\Http\Requests;
use Illuminate\Http\Request;
use Closet\Http\Requests\CreateVoteRequest;

class ShopVoteController extends Controller
{
	public function create(CreateVoteRequest $request,Shop $shop)
	{
        $userVotes = $shop->voteFromUser($request->user())->count();
       
        if($userVotes > 0)
        {
          $shop->voteFromUser($request->user())->first()->delete();
        }

		$shop->votes()->create([
			'type' => $request->type,
			'user_id' => $request->user()->id,
			]);

		return response()->json(null, 200);
	}

	public function delete(Request $request,Shop $shop)
	{
		$userVotes = $shop->voteFromUser($request->user())->count();
       
        if($userVotes > 0)
        {
          $shop->voteFromUser($request->user())->first()->delete();
        }

		return response()->json(null, 200);

	}

    public function show(Request $request,Shop $shop)
    {
    	
    	$response = [
    		'up' => null,
    		'down' => null,
    		'user_vote' => null,
    	];

    	$response['up'] = $shop->upVotes()->count();
    	$response['down'] = $shop->downVotes()->count();

    	if ($request->user()) {
    		$voteFromUser = $shop->voteFromUserAlt($request->user())->first();
    		$response['user_vote'] = $voteFromUser ? $voteFromUser->type : null;
    	}

    	return response()->json([
    		'data' => $response
    		], 200);

    }
}