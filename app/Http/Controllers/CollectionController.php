<?php

namespace Closet\Http\Controllers;

use Image;
use Fractal;
use Storage;
use Illuminate\Http\Request;
use Closet\Models\{Shop, Collection, CollectionImage, CollectionProduct};
use Closet\Jobs\Collection\{CollectionThumbnailUpload, CollectionPhotoUpload};
use Closet\Jobs\Images\DeleteImage;
use Closet\Transformer\{CollectionTransformer, CollectionImageTransformer, CollectionProductTransformer, AddProductTransformer};

class CollectionController extends Controller
{

    public function index(Collection $collection)
    {
      return view('collection.show', [

        'collection' => $collection,

        ]);
    }
    public function collectionAjax(Request $request, Shop $shop)
    {
      if (!$request->user() || $request->user()->id !== $shop->user_id ) {
        $collection = $shop->collection()->where('visibility', 'public')->get();
      } else {
        $collection = $shop->collection()->get();
      }
      return response()->json(Fractal::collection($collection, new CollectionTransformer));
    }

   	public function store(Request $request, Shop $shop)
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
      return response()->json($collection);
   	}

   	public function delete(Collection $collection)
   	{
      $this->authorize('delete', $collection);

      $path = 'collection/thumbnail/'.$collection->image_filename;
      $this->dispatch(new DeleteImage($path));

      $photos = $collection->images->pluck('filename');
      foreach($photos as $photo){
      Storage::disk('s3images')->delete('collection/photo/' . $photo);
      }
      $collection->delete();

      return ;
   	}
    public function edit(Collection $collection)
    {
      $this->authorize('edit', $collection);

      return view('collection.edit_vue' , [

        'collection' => $collection

      ]);
    }

   	public function updateInfo(Request $request, Collection $collection)
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

    public function getPhoto(Collection $collection)
    {
      return response()->json(Fractal::collection($collection->images()->get(), new CollectionImageTransformer));
    }

    public function uploadPhoto(Request $request, Collection $collection, $id)
    {
      if(CollectionImage::where('collection_id', $id)->count() <= 10){

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

    public function getProduct(Collection $collection, $collectionId)
    {
          $collections = Collection::findOrFail($collectionId);
          $product = $collections->products()->get();

          return response()->json(Fractal::collection($product,new CollectionProductTransformer ));
    }

    public function storeProduct(CollectionProduct $collection, $collectionId, $productId)
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

    public function deleteProduct(CollectionProduct $collection, $collectionId, $productId)
    {
        $match = ['product_id' => $productId, 'collection_id' => $collectionId];
        $product = $collection->where($match);
        $product->delete();

        return response()->json(null, 200);
    }

    public function getAddCollection(Shop $shop, $productId)
    {
          $collection = $shop->collection()->latestFirst()->get();
          return response()->json(Fractal::collection($collection,new AddProductTransformer(['id' => $productId])));
    }
}
