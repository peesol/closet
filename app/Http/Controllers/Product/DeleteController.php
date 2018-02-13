<?php

namespace Closet\Http\Controllers\Product;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Jobs\Images\DeleteImage;
use Closet\Models\{UsedProduct,Product};

class DeleteController extends Controller
{
  public function deleteUsedProduct(UsedProduct $product)
  {
      $path = 'used/thumbnail/' . $product->thumbnail;
      $this->dispatch(new DeleteImage($path));
    foreach ($product->productimages as $image) {
      $path = 'used/photo/' . $image->filename;
      $this->dispatch(new DeleteImage($path));
    }
    $product->delete();

    return redirect()->back();
  }

  public function deleteNewProduct(Product $product)
  {
    $this->authorize('delete', $product);
      $path = 'product/thumbnail/' . $product->thumbnail;
      $this->dispatch(new DeleteImage($path));
    foreach ($product->productimages as $image) {
      $path = 'product/photo/' . $image->filename;
      $this->dispatch(new DeleteImage($path));
    }
    $product->delete();

    return redirect()->back();
  }
}
