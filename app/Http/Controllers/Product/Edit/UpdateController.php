<?php

namespace Closet\Http\Controllers\Product\Edit;

use Storage;
use Closet\Models\Product;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Jobs\Product\ProductUpdate;
use Closet\Jobs\Images\DeleteImage;

class UpdateController extends Controller
{
  public function index(Product $product)
  {
    $this->authorize('edit', $product);

    return view('product.settings.edit', ['product' => $product]);
  }

  public function update(Request $request, Product $product)
  {
    $this->authorize('update', $product);

    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    $product->visibility = $request->visibility;
    if (!empty($request->thumbnail)) {
        if (!empty($product->thumbnail)) {
          $path = 'product/thumbnail/' . $product->thumbnail;
          $this->dispatch((new DeleteImage($path))->onQueue('delete_img'));
        }
        $thumbnail = $request->thumbnail;

        $fileName = uniqid('p_thumb');

        $exploded = explode(',', $thumbnail);

        $decoded = base64_decode($exploded[1]);

        Storage::disk('uploads')->put('product/thumbnail/' . $fileName, $decoded);

        $product->thumbnail = $fileName . '.jpg';

        $this->dispatch((new ProductUpdate($product, $fileName))->onQueue('upload'));
    }

    $product->save();
    return response()->json(null, 200);
  }
}
