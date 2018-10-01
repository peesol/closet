<?php

namespace Closet\Http\Controllers\Admin;

use DB;
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

  public function databasePage()
  {
    return view('admin.database.query');
  }

  public function query(Request $request)
  {
    $where = $request->where;
    $data = DB::table($request->table)->where($request->where, $request->arg, $request->number)->get();
    $data= json_decode( json_encode($data), true);

    return view('admin.database.result', ['data' => $data]);
  }
}
