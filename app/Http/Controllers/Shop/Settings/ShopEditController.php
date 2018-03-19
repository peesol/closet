<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Closet\Models\Shop;
use Illuminate\Http\Request;
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Controllers\Controller;
use Closet\Http\Requests\ShopUpdateRequest;
use Closet\Jobs\ShopImage\{UploadCover, UploadThumbnail};

class ShopEditController extends Controller
{
  public function index(Shop $shop)
  {
    $this->authorize('edit', $shop);

    return view('shop.settings.edit' , [ 'shop' => $shop ]);
  }

  public function getUserInfomation(Shop $shop)
  {
    $data = [
      'id' => $shop->id,
      'cover' => $shop->getCover(),
      'thumbnail' => $shop->getThumbnail(),
      'description' => $shop->description,
      'name' => $shop->name,
      'slug' => $shop->slug,
    ];
    return response()->json($data);
  }
  public function updatePublicInfo(ShopUpdateRequest $request, Shop $shop)
  {
    $this->authorize('update', $shop);

    $shop->update([
      'name' => $request->name,
      'slug' => $request->slug,
      'description' => $request->description,
    ]);

    return response()->json();
  }

  public function updatePrivateInfo(Request $request, Shop $shop)
  {
    $this->authorize('update', $shop);

    $shop->user->update([
      'address' => $request->address,
      'phone' => $request->phone,
    ]);

    return response()->json(null, 200);
  }
  public function updateThumbnail(Request $request, Shop $shop)
  {
    if (!empty($shop->thumbnail)) {
      $path = 'profile/thumbnail/' . $shop->thumbnail;
      $this->dispatch(new DeleteImage($path));
    }
    $thumbnail = $request->thumbnail;
    $fileName = uniqid('profile_thumb_' . $request->user()->id);

    $this->dispatch(new UploadThumbnail($shop, $thumbnail, $fileName));

    return response()->json(null, 200);
  }

  public function updateCover(Request $request, Shop $shop)
  {
    if (!empty($shop->cover)) {
      $path = 'profile/cover/'.$shop->cover;
      $this->dispatch(new DeleteImage($path));
    }

    $cover = $request->cover;
    $fileName = uniqid('cov_'.$request->user()->id);

    $this->dispatch(new UploadCover($shop, $cover, $fileName));

    return response()->json(null, 200);
  }

}
