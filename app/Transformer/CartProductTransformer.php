<?php

namespace Closet\Transformer;

use Closet\Models\Product;
use League\Fractal\TransformerAbstract;


class CartProductTransformer extends TransformerAbstract
{

	public function transform(Product $product)
	{
		return [
		'id' => $product->id,
		'name' => $product->name,
		'price' => $product->price,
		'discount_price' => $product->discount_price,
		'shop_name' => $product->shop->name,
		'shop_id' => $product->shop->id,
		];
	}

}
