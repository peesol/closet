<?php

namespace Closet\Http\Controllers\Product\Photo;

use Fractal;
use Storage;
use Illuminate\Http\Request;
use Closet\Jobs\Product\UploadProductPhoto;
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Product, ProductImage};
use Closet\Transformer\ProductImageTransformer;

class PhotoController extends Controller
{
  public function get(Product $product)
  {
    return response()->json(
         Fractal::collection($product->productimages()->get())
              ->transformWith(new ProductImageTransformer)
              ->toArray()
              );
  }
  public function upload(Request $request, Product $product)
  {
      if(ProductImage::where('product_id', $product->id)->count() < 7){
        $photos = [];
        $response = [];
        foreach ($request->file('image') as $image) {
          $photo = uniqid('p_img_'.$request->user()->id);
          Storage::disk('uploads')->putFileAs('product/photo/', $image, $photo);
          $photos[] = $photo;
          $created = $product->productimages()->create([
              'filename' => $photo . '.jpg'
          ]);
          $response[] = $created;
        }
        $this->dispatch(new UploadProductPhoto($photos));
        return response()->json($response);

      } else {
        return false;
      }
  }

  public function delete(ProductImage $product,$id)
  {
      $photo = ProductImage::find($id);
      $path = 'product/photo/' . $photo->filename;
      $this->dispatch(new DeleteImage($path));
      $photo->delete();

      return response()->json(null, 200);
  }
}
