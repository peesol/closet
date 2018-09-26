<?php

namespace Closet\Http\Controllers\Notification\Settings;

use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;

class NotificationSettingsController extends Controller
{
  public function get(Request $request)
  {
    $data = $request->user()->options;

    return response()->json(json_decode($data));
  }

  public function update(Request $request)
  {
    $update = $request->changes;
    $request->user()->update([
      'options' => json_encode($update)
    ]);

    return ;
  }
}
