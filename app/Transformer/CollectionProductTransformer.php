<?php

namespace Closet\Transformer;

use Closet\Models\Product;
use League\Fractal\TransformerAbstract;


class CollectionProductTransformer extends TransformerAbstract
{

	public function transform(Product $product)
	{
		return [
		'id' => $product->id,
		'shop' => $product->shop->name,
		'category' => $product->category->name,
		'uid' => $product->uid,
		'name' => $product->name,
		'slug' => $product->shop->slug,
		'price' => $product->price,
		'thumbnail' => $product->getImage(),
		];
	}

}
