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

  public function create(Request $request, Showcase $showcase)
  {
    $showcase = $request->user()->showcase()->create([
      'shop_id' => $request->user()->shop->id,
      'name' => $request->name,
      'order' => $request->order,
      'show' => true
      ]);
    return response()->json($showcase);
  }

  public function remove(Showcase $showcase)
  {
    $showcase->delete();

    return response()->json(null, 200);
  }

  public function showOption(Request $request, Showcase $showcase)
  {
    if($showcase->show == true)
    {
      $showcase->update([ 'show' => false ]);
    } else {
      $showcase->update([ 'show' => true ]);
    }
    return response()->json(null, 200);
  }

  public function updateOrder(Request $request)
  {
    foreach ($request->showcases as $index => $showcase) {
      Showcase::find($showcase['id'])->update(['order' => $index]);
    }
    return response()->json($request->user()->showcase);
  }
}
