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
        $this->dispatch(new DeleteImage($path));
        }
        $thumbnail = $request->thumbnail;
        $fileName = uniqid('col_thumb');
        $this->dispatch(new CollectionThumbnailUpload($collection, $thumbnail, $fileName));
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

      $this->dispatch(new CollectionPhotoUpload($images, $id));

    } else {
      return false;
    }
  }

  public function deletePhoto(CollectionImage $collection,$id)
  {
      $photo = CollectionImage::find($id);
      $file = $photo->filename;

      $path = 'collection/photo/' . $file;
      $this->dispatch(new DeleteImage($path));

      $photo->delete();

      return response()->json(null, 200);
  }

  public function deleteProduct(CollectionProduct $collection, $collectionId, $productId)
  {
      $match = ['product_id' => $productId, 'collection_id' => $collectionId];
      $product = $collection->where($match);
      $product->delete();

      return response()->json(null, 200);
  }

}
