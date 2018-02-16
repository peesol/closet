<?php

namespace Closet\Http\Controllers\Showcase;

use Fractal;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Showcase, ShowcaseProduct, Shop};
use Closet\Transformer\ShowcaseProductTransformer;

class ShowcaseEditController extends Controller
{
  public function index(Request $request, Shop $shop, Showcase $showcase)
  {
    $this->authorize('edit', $shop);
    $shop = $request->user()->shop()->first();

    return view('shop.settings.showcase_edit', [
              'showcase' => $showcase,
              'shop' => $shop
    ]);
  }

  public function update(Shop $shop, Showcase $showcase, Request $request)
  {
    $this->authorize('update', $shop);
    $showcase->update([
      'name' => $request->name,
    ]);

    return response()->json(null, 200);
  }

  public function getProduct(Shop $shop, Showcase $showcase)
  {
      $product = $shop->product->where('visibility', 'public');

      return response()->json(Fractal::collection($product, new ShowcaseProductTransformer($showcase->id) ));
  }

  public function storeProduct(Shop $shop, Showcase $showcase, $productId)
  {
    $this->authorize('update', $shop);

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
