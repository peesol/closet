<?php

namespace Closet\Transformer;

use Closet\Models\Shop;
use League\Fractal\TransformerAbstract;


class ShopTransformer extends TransformerAbstract
{

	public function transform(Shop $shop)
	{
		return [
		'id' => $shop->id,
		'name' => $shop->name,
		'slug' => $shop->slug,
		'image' => $shop->getThumbnail(),
		];
	}

}
