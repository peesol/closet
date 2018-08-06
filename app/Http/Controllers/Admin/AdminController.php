<?php

namespace Closet\Http\Controllers\Admin;

use Auth;
use Closet\Models\Banner;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function homePage()
  {
    return view('admin.index');
  }
}
