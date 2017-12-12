<?php

namespace Closet\Transformer;

use Closet\Models\Collection;
use League\Fractal\TransformerAbstract;


class AddProductTransformer extends TransformerAbstract
{
    
    private $params = [];

    function __construct($params = [])
    {
        $this->params = $params;
    }

	public function transform(Collection $collection)
	{
		return [
		'id' => (int) $collection->id,
		'name' => $collection->name,
		'added' => $collection->addedToCollection($this->params),
		];		
	}

}