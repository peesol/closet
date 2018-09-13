<?php

namespace Closet\Http\Controllers\Collection;

use Fractal;
use Storage;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Collection, CollectionImage, CollectionProduct};
use Closet\Jobs\Collection\{CollectionThumbnailUpload, CollectionPhotoUpload};
use Closet\Jobs\Images\DeleteImage;


class CollectionEditController extends Controller
{
  public function edit(Collection $collection)
  {
    $this->authorize('edit', $collection);

    return view('collection.edit' , [

      'collection' => $collection

    ]);
  }

  public function update(Request $request, Collection $collection)
  {
    $this->authorize('update', $collection);

    $update = $collection->update([
      'name' => $request->name,
      'visibility' => $request->visibility,
      'description' => $request->description,
      ]);

    if (!empty($request->thumbnail)) {

        if (!empty($collection->thumbnail)) {
        $path = 'collection/thumbnail/' . $collection->thumbnail;
        $this->dispatch((new DeleteImage($path))->onQueue('delete_img'));
        }
        $thumbnail = $request->thumbnail;
        $fileName = uniqid('col_thumb');

        $exploded = explode(',', $thumbnail);

        $decoded = base64_decode($exploded[1]);

        Storage::disk('uploads')->put('collection/thumbnail/' . $fileName, $decoded);

        $this->dispatch((new CollectionThumbnailUpload($collection, $fileName))->onQueue('upload_medium'));
    }

    return response()->json($update);
  }

  public function uploadPhoto(Request $request, Collection $collection, $id)
  {
    $this->authorize('update', $collection);

    if(CollectionImage::where('collection_id', $id)->count() <= 10) {

      $images = [];
      foreach ($request->file('image') as $file) {
        $name = uniqid('c_img');
        Storage::disk('uploads')->putFileAs('collection/photo/', $file, $name);
        $images[] = $name;

        $data = CollectionImage::create([
            'collection_id' => $id,
            'filename' => $name . '.jpg'
        ]);
      }

      $this->dispatch((new CollectionPhotoUpload($images, $id))->onQueue('upload_medium'));

    } else {
      return false;
    }
  }

  public function deletePhoto(CollectionImage $collection,$id)
  {
      $photo = CollectionImage::find($id);
      $file = $photo->filename;

      $path = 'collection/photo/' . $file;
      $this->dispatch((new DeleteImage($path))->onQueue('delete_img'));

      $photo->delete();

      return response()->json(null, 200);
  }

  public function getMyProduct(Collection $collection, Request $request)
  {
    $products = $request->user()->products()->latestFirst()->get();

    $data = [];

    foreach ($products as $product) {
      $data[] = [
        'id' => $product->id,
        'name' => $product->name,
        'added' => $collection->addedToCollection($product->id),
        'thumbnail' => $product->thumbnail,
      ];
    }

    return response()->json($data);
  }

  public function deleteProduct(CollectionProduct $collection, $collectionId, $productId)
  {
      $match = ['product_id' => $productId, 'collection_id' => $collectionId];
      $product = $collection->where($match);
      $product->delete();

      return response()->json(null, 200);
  }

}
