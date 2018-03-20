<?php

namespace Closet\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Note, Product, Shop};

class NoteController extends Controller
{
  public function index(Request $request, Shop $shop)
  {
    $products = Auth::user()->notedProduct()->get();

    return view('user.note.index', [
      'products' => $products
    ]);
  }

  public function create(Request $request)
  {
    $match = ['product_id' => $request->product_id, 'shop_id' => $request->shop_id];
    $saved = Note::where($match)->count();
    if($saved > 0)
    {

      Note::where($match)->first()->delete();

    } else {
      Note::create([
        'shop_id' => $request->shop_id,
        'product_id' => $request->product_id
      ]);
    }
    return response()->json();
  }
}
