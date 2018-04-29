<?php

namespace Closet\Transformer;

use Closet\Models\Product;
use League\Fractal\TransformerAbstract;

class DiscountProductTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
		      'id' => $product->id,
		      'name' => $product->name,
		      'price' => $product->price,
		      'discount_price' => $product->discount_price,
		      'discount_date' => date('d-m-Y', strtotime($product->discount_date)),
        ];
    }
}
