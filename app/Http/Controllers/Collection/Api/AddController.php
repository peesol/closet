<?php

namespace Closet\Http\Controllers\Collection\Api;

use Fractal;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Shop, CollectionProduct};
use Closet\Transformer\AddProductTransformer;

class AddController extends Controller
{
  public function create(CollectionProduct $collection, $collectionId, $productId)
  {
      $match = ['product_id' => $productId, 'collection_id' => $collectionId];
      $saved = $collection->where($match)->count();

      if($saved > 0)
      {
        $collection->where($match)->first()->delete();
      }
      else{
       $collection->create([
          'collection_id' => $collectionId,
          'product_id' => $productId,
          ]);
      }
      return response()->json(null, 200);
  }

  public function getAddedProduct(Shop $shop, $productId)
  {
    $collection = $shop->collection()->latestFirst()->get();
    return response()->json(Fractal::collection($collection,new AddProductTransformer(['id' => $productId])));
  }

}
