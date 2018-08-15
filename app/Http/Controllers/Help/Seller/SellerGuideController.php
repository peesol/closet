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
  public function editProduct()
  {
    return view('help.seller.edit_product');
  }
  public function promotion()
  {
    return view('help.seller.promotion');
  }
  public function selling()
  {
    return view('help.seller.selling');
  }
  public function editProfile()
  {
    return view('help.seller.edit_profile');
  }
  public function thumbnail()
  {
    return view('help.seller.thumbnail');
  }
  public function showcase()
  {
    return view('help.seller.showcase');
  }
  public function collection()
  {
    return view('help.seller.collection');
  }
}
