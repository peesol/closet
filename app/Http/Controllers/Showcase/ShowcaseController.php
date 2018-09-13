<?php

namespace Closet\Http\Controllers\Showcase;

use Illuminate\Http\Request;
use Closet\Models\{Showcase, Shop};
use Closet\Http\Controllers\Controller;

class ShowcaseController extends Controller
{
  public function get(Request $request, Shop $shop)
  {
      $showcase = $request->user()->showcase;
      return response()->json($showcase);
  }

  public function create(Request $request, Shop $shop, Showcase $showcase)
  {
    $this->authorize('update', $shop);
    $shop = $request->user()->shop()->first();

    $showcase = $shop->showcase()->create([
      'name' => $request->name,
      'order' => $request->order,
      'show' => true
      ]);
    return response()->json($showcase);
  }

  public function remove(Shop $shop, Showcase $showcase)
  {
    $this->authorize('delete', $shop);
    $showcase->delete();

    return response()->json(null, 200);
  }

  public function showOption(Request $request, Shop $shop, Showcase $showcase)
  {
    $this->authorize('update', $shop);

    if($showcase->show == true)
    {
      $showcase->update([ 'show' => false ]);
    } else {
      $showcase->update([ 'show' => true ]);
    }
    return response()->json(null, 200);
  }

  public function updateOrder(Shop $shop, Request $request)
  {
    $this->authorize('update', $shop);
    foreach ($request->showcases as $showcaseUpdate) {
      Showcase::find($showcaseUpdate['id'])->update(['order' => $showcaseUpdate['order']]);
    }
    return response()->json($request->user()->showcase);
  }
}
