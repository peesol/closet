<?php

namespace Closet\Http\Controllers;

use Cache;
use Auth;
use App;
use Closet\Models\{Category, Translation, Product, Shop};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      $categories = Cache::get('categories');
      $products = Product::popular()->take(10)->get();
      $shops = Shop::orderBy('view_count', 'desc')->take(10)->get();
      return view('home', [
        'categories' => $categories,
        'products' => $products,
        'shops' => $shops,
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
