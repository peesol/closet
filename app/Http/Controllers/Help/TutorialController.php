<?php

namespace Closet\Http\Controllers\Help;

use Mail;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Mail\Report;

class TutorialController extends Controller
{
  public function homePage()
  {
    return view('help.home');
  }
  public function askPage()
  {
    return view('help.ask');
  }
  public function askPost(Request $requests)
  {
    $report = [
      'name' => $requests->name,
      'email' => $requests->email,
      'body' => $requests->body,
    ];
    Mail::to('pfjeans@gmail.com')->queue(new Report($report));
    return redirect()->route('reportSuccess');
  }
}
