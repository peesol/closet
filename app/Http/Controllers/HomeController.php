<?php

namespace Closet\Http\Controllers;

use Closet\Models\{Category, Translation};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;
use Cache;
use Auth;
use App;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      $categories = Cache::rememberForever('categories', function() {
        return Category::all();
      });
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
