<?php

namespace Closet\Http\Controllers\Product\Sell;

use Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Jobs\Product\UsedUpload;
use Closet\Jobs\Images\DeleteImage;
use Closet\Models\{UsedProduct,UsedProductImage};

class UsedProductController extends Controller
{
  public function index()
  {
    return view('product.sell_used');
  }

  public function create(Request $request, UsedProduct $product, UsedProductImage $productimage)
  {
    $type_id = !$request->type_id ? $request->type_id : 1;
    $uid = uniqid('p_used');
    $shop = $request->user()->shop()->first();
    $product = $shop->used()->create([
      'uid' => $uid,
      'name' => $request->name,
      'category_id' => $request->category_id,
      'subcategory_id' => $request->subcategory_id,
      'type_id' => $type_id,
      'price' => $request->price,
      'description' => $request->description,
      'thumbnail' => '',
    ]);

    $images =  $request->file('image');
    if($images[0]) {
      $thumbnail = uniqid('p_thumb_2_').$request->user()->id;
      Storage::disk('uploads')->putFileAs('used/thumbnail/', $images[0], $thumbnail);
    }
    $photos = [];
    foreach ($images as $image) {
      $photo = uniqid('p_img_2_').$request->user()->id;
      Storage::disk('uploads')->putFileAs('used/photo/', $image, $photo);
      $photos[] = $photo;
    }

    $this->dispatch(new UsedUpload($product, $thumbnail, $photos));
    return response()->json();
  }

}
