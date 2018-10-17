<?php

namespace Closet\Http\Controllers\Api;

use DB;
use Closet\Models\{Shop};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Transformer\ShowcaseProductTransformer;

class Getter extends Controller
{
  public function getShop($id)
  {
    $data = Shop::find($id);

    return response()->json([
      'id' => $data->id,
      'name' => $data->name,
      'slug' => $data->slug,
    ]);
  }
  public function getBankAccount($id)
  {
    $data = DB::table('accounts')->where('shop_id', $id)->get();

    return response()->json($data);
  }

  public function getMyProduct(Request $request)
  {
    $data = $request->user()->products()->latestFirst()->get();

    return response()->json($data);
  }

  public function getShipping($id)
  {
    $data = DB::table('shippings')->where('shop_id', $id)->get();

    return response()->json(json_decode($data[0]->shipping_methods, true));
  }
}
