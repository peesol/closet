<?php

namespace Closet\Http\Controllers\Api;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class MiddlewareApi extends Controller
{
  public function api(Request $request)
  {
    return $request->user();
  }
}
