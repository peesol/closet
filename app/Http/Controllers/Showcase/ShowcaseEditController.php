<?php

namespace Closet\Http\Controllers\Showcase;

use Fractal;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Showcase, ShowcaseProduct, Shop};
use Closet\Transformer\ShowcaseProductTransformer;

class ShowcaseEditController extends Controller
{
  public function index(Request $request, Showcase $showcase)
  {
    $shop = $request->user()->shop;

    return view('shop.settings.showcase_edit', [
              'showcase' => $showcase,
              'shop' => $shop
    ]);
  }

  public function update(Request $request, Showcase $showcase)
  {
    $showcase->update([
      'name' => $request->name,
    ]);

    return response()->json(null, 200);
  }

  public function getProduct(Request $request, Showcase $showcase)
  {
      $product = $request->user()->products->where('visibility', 'public');

      return response()->json(Fractal::collection($product, new ShowcaseProductTransformer($showcase->id) ));
  }

  public function storeProduct(Showcase $showcase, $productId)
  {

    $match = ['product_id' => $productId, 'showcase_id' => $showcase->id];

    $saved = ShowcaseProduct::where($match)->count();

    if($saved > 0)
    {
      ShowcaseProduct::where($match)->first()->delete();
    } else {
      ShowcaseProduct::create([
        'showcase_id' => $showcase->id,
        'product_id' => $productId,
        ]);
    }
    return response()->json(null, 200);
  }
}
