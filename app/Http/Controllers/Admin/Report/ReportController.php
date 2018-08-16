<?php

namespace Closet\Http\Controllers\Admin\Report;

use Session;
use Closet\Models\Report;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class ReportController extends Controller
{
  public function index()
  {
    $reports = Report::orderBy('created_at', 'desc')->get();
    return view('admin.report.index', ['reports' => $reports]);
  }

  public function delete(Request $request)
  {
    Report::find($request->id)->delete();
    Session::flash('msg', "SUCCESS");
    return redirect()->back();
  }
}
