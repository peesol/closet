<?php

namespace Closet\Http\Controllers\Product\Sell;

use Auth;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closet\Jobs\Product\ProductUpload;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Product,ProductImage};

class NewProductController extends Controller
{
  public function index()
  {
    if(!Auth::user()->account->count() || !Auth::user()->shop->shipping) {
      return view('product.error.cant_sell', ['shop' => Auth::user()->shop]);
    } else {
      return view('product.sell');
    }
  }

  public function create(Request $request, Product $product, ProductImage $productimage)
  {
    $type_id = $request->type_id == 'null' ? '1' : $request->type_id;
    $uid = uniqid('p_');
    $shop = $request->user()->shop()->first();
    $product = $shop->product()->create([
      'uid' => $uid,
      'name' => $request->name,
      'category_id' => $request->category_id,
      'subcategory_id' => $request->subcategory_id,
      'type_id' => $type_id,
      'shop_type' => $shop->usertype,
      'price' => $request->price,
      'description' => $request->description,
      'visibility' => $request->visibility,
      'thumbnail' => '',
    ]);

    $images =  $request->file('image');
    if($images[0]) {
      $thumbnail = uniqid('p_thumb_').$request->user()->id;
      Storage::disk('uploads')->putFileAs('product/thumbnail/', $images[0], $thumbnail);
    }
    $photos = [];
    foreach ($images as $image) {
      $photo = uniqid('p_img_').$request->user()->id;
      Storage::disk('uploads')->putFileAs('product/photo/', $image, $photo);
      $photos[] = $photo;
    }

    $this->dispatch((new ProductUpload($product, $thumbnail, $photos))->onQueue('upload'));

    return response()->json();
  }
  public function after()
  {
    return view('product.after_sell');
  }

}
