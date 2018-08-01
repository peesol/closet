<?php

namespace Closet\Http\Controllers;

use Cache;
use Auth;
use App;
use DB;
use Closet\Models\{Category, Translation, Product, Shop, UsedProduct};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      $categories = Cache::get('categories');
      $products = Product::popular()->take(10)->get();
      $shops = Shop::orderBy('view_count', 'desc')->take(10)->get();
      $banners =  DB::table('banners')->where('type', 'home')->get();
      return view('main.home', [
        'categories' => $categories,
        'products' => $products,
        'shops' => $shops,
        'banners' => $banners,
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
      $products = Product::popular()->take(100)->paginate(30);
      return view('main.trending', [ 'products' => $products ]);
    }
    public function secondhand()
    {
      $products = UsedProduct::paginate(30);
      return view('main.used_market', [ 'products' => $products ]);
    }
}
