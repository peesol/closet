<?php

namespace Closet\Http\Controllers;

use Closet\Models\{Category, Translation};
use Illuminate\Http\Request;
use Closet\Repositories\UserRepository;
use Auth;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
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
}
