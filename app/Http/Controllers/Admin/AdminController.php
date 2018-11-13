<?php

namespace Closet\Http\Controllers\Admin;

use DB;
use Auth;
use Closet\Models\{Banner};
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class AdminController extends Controller
{
  public function homePage()
  {
    return view('admin.index');
  }

  public function databasePage()
  {
    return view('admin.database.query');
  }

  public function grantPage()
  {
    return view('admin.database.grant', ['data' => null]);
  }
  public function grantGet(Request $request)
  {
    $data = DB::table('shops')->where('slug', $request->shop_type)->get();
    return view('admin.database.grant', [
      'message' => 'GET',
      'data' => $data
    ]);
  }
  public function grantUser(Request $request)
  {
    DB::table('shops')->where('id', $request->id)->update(['usertype' => $request->type]);
    DB::table('products')->where('shop_id', $request->id)->update(['shop_type' => $request->type]);
    return view('admin.database.grant', [
      'message' => 'Success',
      'data' => null
    ]);
  }
  public function grantPromotion(Request $request)
  {
    $data = DB::table('shops')->where('id', $request->id)->update([
      'promotion_points' => json_encode([
        'campaign' => (int) $request->campaign,
        'discount' => (int) $request->discount,
        'flash_sale' => (int) $request->flash_sale,
      ])
    ]);

    return view('admin.database.grant', [
      'message' => 'Success',
      'data' => null
    ]);
  }

  public function query(Request $request)
  {
    $data = DB::table($request->table)->where($request->where, $request->arg, $request->number)->get();
    $data= json_decode( json_encode($data), true);

    return view('admin.database.result', ['data' => $data]);
  }

  public function insert(Request $request)
  {
    if ($request->password == 'ThisIsCloset2018') {
      $data = DB::table($request->table)->where($request->where, $request->arg, $request->number)->update([
        $request->column => $request->value
      ]);
      $data= json_decode( json_encode($data), true);
      return view('admin.database.result', ['data' => $data]);
    }
  }
}
