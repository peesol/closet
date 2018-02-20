<?php

namespace Closet\Http\Controllers;

use Cache;
use Auth;
use App;
use Closet\Models\{Category, Translation};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      $categories = Cache::get('categories');
      return view('home', [
        'categories' => $categories,
      ]);
    }

    public function shops()
    {
      return view('shops');
    }
    public function brands()
    {
      return view('shops');
    }
    public function trending()
    {
      return view('shops');
    }
}
