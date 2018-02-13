<?php

namespace Closet\Http\Controllers\Product\Edit;

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

    $update = $product->update([
      'name' => $request->name,
      'price' => $request->price,
      'description' => $request->description,
      'visibility' => $request->visibility,
    ]);

    if (!empty($request->thumbnail)) {

        if (!empty($product->thumbnail)) {
          $path = 'product/thumbnail/' . $product->thumbnail;
          $this->dispatch(new DeleteImage($path));
        }
        $thumbnail = $request->thumbnail;
        $fileName = uniqid('p_thumb');
        $this->dispatch(new ProductUpdate($product, $thumbnail, $fileName));
    }
    return response()->json(null, 200);
  }
}
