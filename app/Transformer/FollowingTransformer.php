<?php

namespace Closet\Transformer;

use Closet\Models\Shop;
use League\Fractal\TransformerAbstract;


class FollowingTransformer extends TransformerAbstract
{
	protected $availableIncludes = [	

	'product'

	];

	public function transform(Shop $shop)
	{
		return [
		'id' => $shop->id,
		'user_id' => $shop->user_id,
		'name' => $shop->name,
		'slug' => $shop->slug,
		'img' => $shop->image_filename
		];			
	}

	public function includeProduct(Shop $shop)
	{

        $products = $shop->product;

		return $this->collection($products, new ProductTransformer);

	}
}