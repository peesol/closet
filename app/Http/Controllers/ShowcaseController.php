<?php

namespace Closet\Http\Controllers;

use Fractal;

use Closet\Models\Shop;
use Closet\Models\Showcase;
use Closet\Models\ShowcaseProduct;
use Illuminate\Http\Request;
use Closet\Transformer\CollectionProductTransformer;
use Closet\Transformer\ShowcaseProductTransformer;

class ShowcaseController extends Controller
{
  public function getShowcase(Request $request)
  {
      $showcase = $request->user()->showcase;

      return response()->json($showcase);
  }

  public function getProduct(Request $request, $id)
  {
      $shop = $request->user()->shop()->first();
      $product = $shop->product->where('visibility', 'public');

      return response()->json(Fractal::collection($product, new ShowcaseProductTransformer($id) ));
  }

  public function storeProduct(ShowcaseProduct $showcase,  $productId, $showcaseId)
  {
    $match = ['product_id' => $productId, 'showcase_id' => $showcaseId];

    $saved = $showcase->where($match)->count();

    if($saved > 0)
    {
      $showcase->where($match)->first()->delete();
    } else {
     $showcase->create([
        'showcase_id' => $showcaseId,
        'product_id' => $productId,
        ]);
    }
    return response()->json(null, 200);
  }

  public function showOption(Showcase $showcase, Request $request)
  {
    if($showcase->show == true)
    {
      $showcase->update([
         'show' => false,
         ]);
    } else {
     $showcase->update([
        'show' => true,
        ]);
    }

    return response()->json(null, 200);
  }

  public function store(Request $request, Showcase $showcase)
  {
    $shop = $request->user()->shop()->first();
    $match = $showcase->where('shop_id', $shop->id)->latest()->value('order');

    $showcase = $shop->showcase()->create([
      'name' => $request->name,
      'order' => $request->order,
      ]);
    return response()->json($showcase);
  }

  public function remove(Showcase $showcase)
  {
    $showcase->delete();

    return response()->json(null, 200);
  }

  public function update(Showcase $showcase, Request $request, $id)
  {
    $target = Showcase::where('id', $id);

    $target->update([
      'name' => $request->name,
    ]);

    return response()->json(null, 200);
  }

  public function updateOrder(Request $request)
  {
    $showcases = Showcase::all();
    foreach ($showcases as $showcase) {
        $showcase->timestamps = false;
        $id = $showcase->id;
        foreach ($request->showcases as $showcaseUpdate) {
            if ($showcaseUpdate['id'] == $id) {
                $showcase->update(['order' => $showcaseUpdate['order']]);
            }
        }
    }

    return response()->json(null, 200);
  }

  public function edit(Request $request, Showcase $showcase)
  {
    $shop = $request->user()->shop()->first();

    return view('shop.settings.showcase_edit', [
              'showcase' => $showcase,
              'shop' => $shop
    ]);
  }

}
