<?php

namespace Closet\Http\Controllers\Help\Buyer;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class BuyerGuideController extends Controller
{
  public function index()
  {
    return view('help.buyer.index');
  }
}
