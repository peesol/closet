<?php

namespace Closet\Http\Controllers\Help\Seller;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class SellerGuideController extends Controller
{
  public function index()
  {
    return view('help.seller.index');
  }
}
