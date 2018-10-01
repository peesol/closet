<?php

namespace Closet\Http\Controllers\Admin\Campaign;

use Closet\Models\Campaign;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class CampaignController extends Controller
{
  public function index()
  {
    $data = Campaign::all();
    return view('admin.campaign.index', ['campaigns' => $data]);
  }
  public function post(Request $request)
  {
    Campaign::create([
      'campaign' => $request->name,
      'rules' => json_encode([
        'price' => $request->price ? (int) $request->price : null,
        'etc' => $request->etc ? $request->etc : null,
      ]),
    ]);
    return redirect()->back();
  }
  public function delete(Request $request)
  {
    Campaign::find($request->id)->delete();
    return redirect()->back();
  }
}
