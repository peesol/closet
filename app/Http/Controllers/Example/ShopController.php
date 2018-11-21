<?php

namespace Closet\Http\Controllers\Example;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class ShopController extends Controller
{
  public function home()
  {
    return view('example.profile.home_ex');
  }
  public function product()
  {
    return view('example.profile.product_ex');
  }
  public function collection()
  {
    return view('example.profile.col_ex');
  }
  public function about()
  {
    return view('example.profile.about_ex');
  }
  public function review()
  {
    return view('example.profile.review_ex');
  }
}
