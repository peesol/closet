<?php

namespace Closet\Transformer;

use Closet\Models\CollectionImage;
use League\Fractal\TransformerAbstract;


class CollectionImageTransformer extends TransformerAbstract
{
	
	public function transform(CollectionImage $collection)
	{
		return [
		'id' => $collection->id,
		'collection_id' => $collection->collection_id,
		'filename' => $collection->getImage(),
		];		
	}

}