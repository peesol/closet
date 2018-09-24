<?php

namespace Closet\Http\Controllers\Product\Show;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Closet\Jobs\Product\UsedUpload;
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Controllers\Controller;
use Closet\Models\{UsedProduct,UsedProductImage};

class UsedProductShowController extends Controller
{
  public function show(UsedProduct $product)
  {
      $contacts = $product->contactsProduct()->where('show', true);
      return view('product.show_used', [
        'product' => $product,
        'contacts' => $contacts,
      ]);
  }

  public function userProduct(Request $request)
  {
    $products = $request->user()->used()->latestFirst()->paginate(20);

    return view('product.myproduct_used', ['products' => $products]);
  }
}
