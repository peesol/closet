<?php

namespace Closet\Http\Controllers\Shop\Settings;

use Storage;
use Closet\Models\Shop;
use Illuminate\Http\Request;
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Controllers\Controller;
use Closet\Http\Requests\ShopUpdateRequest;
use Closet\Jobs\ShopImage\{UploadCover, UploadThumbnail};

class ShopEditController extends Controller
{
  public function index()
  {
    return view('shop.settings.edit');
  }

  public function managePage()
  {
    return view('shop.settings.manage');
  }

  public function getUserInfomation(Request $request)
  {
    $user = $request->user();
    $data = [
      'id' => $user->shop->id,
      'cover' => $user->shop->getCover(),
      'thumbnail' => $user->shop->getThumbnail(),
      'description' => $user->shop->description,
      'name' => $user->shop->name,
      'slug' => $user->shop->slug,
      'phone' => $user->phone,
      'address' => $user->address,
    ];
    return response()->json($data);
  }
  public function updatePublicInfo(ShopUpdateRequest $request)
  {
    $request->user()->shop->update([
      'name' => $request->name,
      'slug' => $request->slug,
      'description' => $request->description,
    ]);

    return response()->json();
  }

  public function updatePrivateInfo(Request $request)
  {
    $request->user()->update([
      'address' => $request->address,
      'phone' => $request->phone,
    ]);

    return response()->json(null, 200);
  }

  public function updateThumbnail(Request $request)
  {
    if (!empty($request->user()->shop->thumbnail)) {
      $path = 'profile/thumbnail/' . $request->user()->shop->thumbnail;
      $this->dispatch((new DeleteImage($path))->onQueue('delete_img'));
    }
    $thumbnail = $request->thumbnail;

    $fileName = uniqid('profile_thumb_' . $request->user()->id);

    $exploded = explode(',', $thumbnail);

    $decoded = base64_decode($exploded[1]);

    Storage::disk('uploads')->put('profile/thumbnail/' . $fileName, $decoded);

    $this->dispatch((new UploadThumbnail($fileName))->onQueue('upload'));

    $request->user()->shop->thumbnail = $fileName . '.jpg';
    $request->user()->shop->save();

    return response()->json(null, 200);
  }

  public function updateCover(Request $request)
  {
    if (!empty($request->user()->shop->cover)) {
      $path = 'profile/cover/'. $request->user()->shop->cover;
      $this->dispatch((new DeleteImage($path))->onQueue('delete_img'));
    }

    $cover = $request->cover;

    $fileName = uniqid('cov_'. $request->user()->id);

    $exploded = explode(',', $cover);

    $decoded = base64_decode($exploded[1]);

    Storage::disk('uploads')->put('profile/cover/' . $fileName, $decoded);

    $this->dispatch((new UploadCover($fileName))->onQueue('upload'));

    $request->user()->shop->cover = $fileName . '.jpg';
    $request->user()->shop->save();

    return response()->json(null, 200);
  }
}
