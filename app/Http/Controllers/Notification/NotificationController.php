<?php

namespace Closet\Http\Controllers\Notification;

use App;
use Date;
use CLoset\Models\User;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Notifications\Ordered;

class NotificationController extends Controller
{
  public function index(Request $request)
  {
    $data = $request->user()->unreadNotifications;

    return view('user.notification.index', ['notifications' => $data]);
  }

  public function get(Request $request)
  {
    $data = $request->user()->notifications;
    $json = [];
    Date::setLocale(App::getLocale());
    foreach ($data as $item) {
      $json[] = array(
        'id' => $item->id,
        'body' => $item->data['body'],
        'read' => $item->read_at ? true : false,
        'created_at' => Date::parse($item->created_at)->diffForHumans(),
      );
    }

    return response()->json($json);
  }

  public function markAsRead(Request $request)
  {
    $request->user()->notifications()->where('id', $request->id)->update([
      'read_at' => now()
    ]);

    return ;
  }

  public function markAllAsRead(Request $request)
  {
    $request->user()->unreadNotifications()->update(['read_at' => now()]);

    return ;
  }

  public function clearAll(Request $request)
  {
    $request->user()->notifications()->delete();

    return ;
  }
}
