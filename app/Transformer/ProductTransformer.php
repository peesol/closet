<?php

namespace Closet\Transformer;

use Closet\Models\Product;
use League\Fractal\TransformerAbstract;


class ProductTransformer extends TransformerAbstract
{

	public function transform(Product $product)
	{
		return [
		'id' => $product->id,
		'category_id' => $product->category_id,
		'name' => $product->name,
		'uid' => $product->uid,
		'price' => $product->price,
		'img_url' => 'https://s3-ap-southeast-1.amazonaws.com/images.closet.com/product/'.$product->productimages->first()->filename,
		];
	}

}
