<?php

namespace Closet\Http\Controllers\Collection;

use Fractal;
use Storage;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Shop, Collection};
use Closet\Jobs\Images\DeleteImage;
use Closet\Transformer\{CollectionProductTransformer};
use Closet\Transformer\{CollectionTransformer, CollectionImageTransformer, AddProductTransformer};


class CollectionController extends Controller
{
  public function index(Request $request)
  {
    $collection = $request->user()->collections;

    return view('collection.mycollection', ['collections' => $collection]);
  }

  public function show(Collection $collection)
  {
    $products = $collection->products;

    return view('collection.show', [
      'collection' => $collection,
      'products' => $products,
    ]);
  }

  public function get(Request $request, Shop $shop)
  {
    if (!$request->user() || $request->user()->id !== $shop->user_id ) {
      $collection = $shop->collection()->where('visibility', 'public')->get();
    } else {
      $collection = $shop->collection()->get();
    }
    return response()->json(Fractal::collection($collection, new CollectionTransformer));
  }

  public function getPhoto(Collection $collection)
  {
    return response()->json(Fractal::collection($collection->images()->get(), new CollectionImageTransformer));
  }

  public function create(Request $request, Shop $shop)
  {
    $shop = $request->user()->shop()->first();
    if(!$request->visibility) {
      $visibility = 'public';
    } else {
      $visibility = $request->visibility;
    }
    $collection = $shop->collection()->create([
      'name' => $request->name,
      'slug' => uniqid('col').$request->user()->id,
      'visibility' => $visibility,
      'description' => $request->description,
      ]);
    return response()->json(Fractal::item($collection, new CollectionTransformer));
  }

  public function delete(Collection $collection)
  {
    $this->authorize('delete', $collection);

    $photos = $collection->images->pluck('filename');

    $target = [];
    foreach($photos as $photo){
      $target[] = 'collection/photo/' . $photo;
    }

    $thumbnail = 'collection/thumbnail/'.$collection->image_filename;

    array_push($target, $thumbnail);

    $this->dispatch((new DeleteImage($target))->onQueue('delete_img'));

    $collection->delete();

    return ;
  }

  public function getProduct(Collection $collection, $collectionId)
  {
    $collections = Collection::findOrFail($collectionId);
    $product = $collections->products()->get();

    return response()->json(Fractal::collection($product,new CollectionProductTransformer ));
  }

}
