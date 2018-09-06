<?php

namespace Closet\Http\Controllers\Product\Vote;

use Closet\Models\Product;
use Closet\Http\Requests;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Http\Requests\CreateVoteRequest;

class VoteController extends Controller
{
  public function create(CreateVoteRequest $request, Product $product)
	{
        $userVotes = $product->voteFromUser($request->user())->count();

        if($userVotes > 0)
        {
          $product->voteFromUser($request->user())->first()->delete();
        }

		$product->votes()->create([
			'type' => $request->type,
			'user_id' => $request->user()->id,
			]);

		return response()->json(null, 200);
	}

	public function delete(Request $request, Product $product)
	{
		$userVotes = $product->voteFromUser($request->user())->count();

        if($userVotes > 0)
        {
          $product->voteFromUser($request->user())->first()->delete();
        }

		return response()->json(null, 200);

	}

    public function show(Request $request, Product $product)
    {
    	$response = [
    		'up' => null,
    		'down' => null,
    		'user_vote' => null,
    		'percentage' => null,
    	];

    	$response['up'] = $product->upVotes()->count();
    	$response['down'] = $product->downVotes()->count();

    	if ($request->user()) {
    		$voteFromUser = $product->voteFromUser($request->user())->first();
    		$response['user_vote'] = $voteFromUser ? $voteFromUser->type : null;
    	}

    	return response()->json([ 'data' => $response ], 200);

    }
}
