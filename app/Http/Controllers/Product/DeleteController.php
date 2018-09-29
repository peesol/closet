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
    $target = [];
    foreach ($product->productimages as $image) {
      $target[] = 'used/photo/' . $image->filename;
    }
    $thumbnail = 'used/thumbnail/' . $product->thumbnail;
    array_push($target, $thumbnail);
    $this->dispatch((new DeleteImage($target))->onQueue('delete_img'));
    $product->delete();

    return redirect()->back();
  }

  public function deleteNewProduct(Product $product)
  {
    $target = [];
    foreach ($product->productimages as $image) {
      $target[] = 'product/photo/' . $image->filename;
    }
    $thumbnail = 'product/thumbnail/' . $product->thumbnail;
    array_push($target, $thumbnail);
    $this->dispatch((new DeleteImage($target))->onQueue('delete_img'));
    $product->delete();

    return redirect()->back();
  }
}
