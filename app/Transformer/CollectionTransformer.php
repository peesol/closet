<?php

namespace Closet\Transformer;

use Closet\Models\Collection;
use League\Fractal\TransformerAbstract;


class CollectionTransformer extends TransformerAbstract
{
	
	public function transform(Collection $collection)
	{
		return [
		'id' => $collection->id,
		'shop_id' => $collection->shop_id,
		'name' => $collection->name,
		'slug' => $collection->slug,
		'visibility' => $collection->visibility,
		'description' => $collection->description,
		'thumbnail' => $collection->getImage(),
		];		
	}

}