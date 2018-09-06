<?php

namespace Closet\Repositories;

use Closet\Models\User;

class UserRepository
{

	public function productsFromFollowing(User $user, $limit = 5)

	{
	//return $user->followedShops()->with('product')->get()->pluck('product');

	return	$user->followedShops()->with(['product' => function($query) use ($limit){

			$query->take($limit);

		}])->get()->pluck('product');
	}
}
