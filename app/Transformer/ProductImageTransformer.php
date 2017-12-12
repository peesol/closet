<?php

namespace Closet\Transformer;

use Closet\Models\ProductImage;
use League\Fractal\TransformerAbstract;


class ProductImageTransformer extends TransformerAbstract
{
	
	public function transform(ProductImage $product)
	{
		return [
		'id' => $product->id,
		'filename' => $product->getImage(),
		];		
	}

}