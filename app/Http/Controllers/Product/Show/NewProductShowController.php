<?php

namespace Closet\Http\Controllers\Product\Show;

use App;
use Storage;
use Cache;
use Image;
use Fractal;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Closet\Jobs\Images\DeleteImage;
use Closet\Http\Controllers\Controller;
use Closet\Http\Requests\ProductListingRequest;
use Closet\Jobs\Product\{ProductUpload, UploadProductPhoto, ProductUpdate};
use Closet\Models\{Product,ProductImage,ProductChoice,Category,Subcategory,CategoryType,Translation, Shop, Note};


class NewProductShowController extends Controller
{
  public function show(Product $product)
  {
    $contacts = $product->contacts()->where('show', true);
    if (Auth::check()) {
      $noted = Note::where(['product_id' => $product->id, 'shop_id' => Auth::user()->id])->count();
    } else {
      $noted = null;
    }

    //$shippingDate = $product->shipping->shipping_date;
    $dates = $product->shipping->shipping_date;

    $shippingDate = [];
    if (count($dates) == 7) {
      $shippingDate[] = __('message.days.everyday');
    } elseif (array_has($dates, [0,1,2,3,4]) && count($dates) == 5) {
      $shippingDate[] = __('message.days.weekday');
    } else {
      foreach ($dates as $day) {
        $shippingDate[] = __('message.days.'.$day);
      }
    }

    return view('product.show', [
      'product' => $product,
      'shipping' => $product->shipping->shipping_methods,
      'shippingDate' => $shippingDate,
      'contacts' => $contacts,
      'noted' => $noted,
    ]);
  }

  public function productAjax(Product $product)
  {
    return response()->json($product);
  }

  public function choiceAjax(Product $product)
  {
    $choices = $product->choices()->get();

    return response()->json($choices);
  }

  public function logView(Request $request, Product $product)
  {
      /*$ip = $request->ip();
       *$user = $request->user() ? $request->user()->id : null;
       *$user_view = $product->views()->create([
       * 'user_id' => $user,
       * 'product_id' => $request->product_id,
       * 'ip' => $ip
       * ]);
      */
    $product->increment('view_count');
    return response()->json(null, 200);
  }
}
