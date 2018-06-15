<?php

namespace Closet\Http\Controllers\Api;

use Closet\Models\{Shop};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

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
}
