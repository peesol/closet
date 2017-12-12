<?php

namespace Closet\Transformer;

use Closet\Models\Product;
use League\Fractal\TransformerAbstract;


class ShowcaseProductTransformer extends TransformerAbstract
{

    private $params = [];

    function __construct($params = [])
    {
        $this->params = $params;
    }

	public function transform(Product $product)
	{
		return [
		'id' => (int) $product->id,
		'name' => $product->name,
    'added' => $product->addedToShowcase($this->params, $product->id),
    'thumbnail' => $product->getImage(),
		];
	}

}
