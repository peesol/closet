<?php

namespace Closet\Http\Controllers\Admin\Banner;

use Hash;
use DB;
use Session;
use Closet\Models\Banner;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class BannerController extends Controller
{
  public function index()
  {
    $banners = DB::table('banners')->get();
    return view('admin.banner.index', ['banners' => $banners]);
  }
  public function create(Request $request)
  {
    $hash = Hash::make('thisiscloset2018');
    $password = $request->password;
    if(Hash::check($password, $hash)){
      Banner::create([
        'type' => $request->type,
        'filename' => $request->filename,
        'link' => $request->link
      ]);
      Session::flash('msg', "SUCCESS");
      return redirect()->back();
    } else {
      Session::flash('msg', "WRONG PASSWORD");
      return redirect()->back();
    }
  }
  public function edit(Banner $banner)
  {
    return view('admin.banner.edit', ['banner' => $banner]);
  }
  public function update(Request $request, Banner $banner)
  {
    $hash = Hash::make('thisiscloset2018');
    $password = $request->password;
    if(Hash::check($password, $hash)){
      $banner->update([
        'type' => $request->type,
        'filename' => $request->filename,
        'link' => $request->link
      ]);
      Session::flash('msg', "SUCCESS");
      return redirect()->back();
    } else {
      Session::flash('msg', "WRONG PASSWORD");
      return redirect()->back();
    }
  }
  public function delete(Request $request, Banner $banner)
  {
    $hash = Hash::make('thisiscloset2018');
    $password = $request->password;
    if(Hash::check($password, $hash)){
      $banner->delete();
      Session::flash('msg', "SUCCESS");
      return redirect()->back();

    } else {
      Session::flash('msg', "WRONG PASSWORD");
      return redirect()->back();
    }
  }
}
