<?php

namespace Closet\Http\Controllers;

use Closet\Models\{Category, Translation};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;
use Auth;
use App;

class HomeController extends Controller
{
    public function index(Request $request)
    {
      if(App::getLocale() == 'en'){
        $categories = Category::all();
      }
      if(App::getLocale() == 'th'){
        $categories = Translation::whereNotNull('category_id')->where('language', 'th')->get();
      }
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
