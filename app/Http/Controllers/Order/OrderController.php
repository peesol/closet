<?php

namespace Closet\Http\Controllers\Order;

use App;
use Cart;
use Auth;
use Fractal;
use Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Order, User, Account};
use Closet\Transformer\OrderTransformer;
use Closet\Mail\{OrderingSeller, OrderingBuyer, TransactionConfirmed, OrderShipped, OrderDeny, OrderCancle};
use Closet\Jobs\Product\DecreaseProduct;

use Closet\Notifications\Seller\{OrderPlaced, OrderCancled, OrderPaid};
use Closet\Notifications\Buyer\{OrderDenied, OrderShippedNotification};

class OrderController extends Controller
{
  public function sellingPage()
  {
    return view('order.selling');
  }
  public function sellingHistoryPage()
  {
    return view('order.history.selling');
  }
  public function buyingPage()
  {
    return view('order.buying');
  }
  public function buyingHistoryPage()
  {
    return view('order.history.buying');
  }
  /*
  |--------------------------------------------------------------------------
  | Ajax
  |--------------------------------------------------------------------------
  */
  public function getSellingInbox()
  {
    $id = Auth::id();
    $order = Order::where('reciever_id', $id)->latest()->get();
    return Fractal::collection($order, new OrderTransformer);
  }
  public function getBuyingInbox()
  {
    $id = Auth::id();
    $order = Order::where('sender_id', $id)->latest()->get();
    return Fractal::collection($order, new OrderTransformer);
  }
  public function getSellingHistory()
  {
    $id = Auth::id();
    $order = Order::onlyTrashed()->where(['reciever_id' => $id], ['deleted_type', '!=', null])->latest()->paginate(40);
    return response($order);
  }
  public function getBuyingHistory()
  {
    $id = Auth::id();
    $order = Order::onlyTrashed()->where(['sender_id' => $id], ['deleted_type', '!=', null])->latest()->paginate(40);
    return response($order);
  }
  /*
  |--------------------------------------------------------------------------
  | Actions
  |--------------------------------------------------------------------------
  */
  public function store(Order $order, Request $request)
  {
    $data = [];
    foreach ($request->products as $product) {
      $data[] = array_except($product, ['rowId', 'tax', 'options.shop_id']);
      $id = array_get($product, 'options.shop_id');
    }
    $order = $order->create([
      'sender_id' => $request->sender_id,
      'sender' => $request->sender_name,
      'reciever_id' => $id,
      'reciever' => $request->reciever_name,
      'uid' => '0' . $request->sender_id . '-0' . $id . '-' . Carbon::now('Asia/Bangkok')->format('dmY-His'),
      'title' => 'Order' . ' - ' . $request->sender_name . ' [' . date("d-m-Y", time()) . ']',
      'body' => json_encode($data),
      'total' => (int)str_replace(',', '', $request->total_price),
      'discount' => $request->discount,
      'shipping' => json_encode([$request->shipping]),
      'address' => $request->address
    ]);

    foreach ($request->products as $product) {
      $rowId = array_get($product, 'rowId');
      Cart::remove($rowId);
    }

    $reciever = User::find($order->reciever_id);
    $sender = User::find($order->sender_id);
    $accounts = Account::where('shop_id', $order->reciever_id)->get();
    $locale = $reciever->country;

    if ($reciever->options['order']) {
      $reciever->notify(new OrderPlaced($order->sender));
    }

    Mail::to($reciever->email)->queue((new OrderingSeller($order, $locale, $sender))->onQueue('email_medium'));
    Mail::to($sender->email)->queue((new OrderingBuyer($order, $accounts, $locale))->onQueue('email_medium'));

    return ;
  }
  /*
  |--------------------------------------------------------------------------
  | Cut out because there is no need to confirm orders
  |--------------------------------------------------------------------------
  */
  // public function confirm(Order $order, Request $request)
  // {
  //   $order->update([
  //     'confirmed' => true,
  //     'shipping_fee' => $request->shipping_fee,
  //   ]);
  //
  //   $sender = User::find($order->sender_id);
  //   $accounts = Account::where('shop_id', $order->reciever_id)->get();
  //   $locale = $sender->country;
  //
  //   Mail::to($sender->email)->queue(new OrderConfirmed($order, $accounts, $locale));
  //
  //   return response()->json(null, 200);
  // }
  //
  public function deny(Order $order, Request $request)
  {
    $order->update([
      'deleted_type' => $request->type
    ]);
    $order->delete();

    if ($request->type === 1) {
      $sender = User::find($order->sender_id);
      $locale = $sender->country;
      if ($sender->options['order']) {
        $sender->notify(new OrderDenied($order->title));
      }
      Mail::to($sender->email)->queue((new OrderDeny($order, $locale, $request->reason))->onQueue('email_low'));
    } else {
      $reciever = User::find($order->reciever_id);
      $locale = $reciever->country;
      $contact = $reciever->email . ' / ' . $reciever->phone;
      if ($reciever->options['order']) {
        $reciever->notify(new OrderCancled($order->title));
      }
      Mail::to($reciever->email)->queue((new OrderCancle($order, $locale, $contact))->onQueue('email_low'));
    }

    return response()->json();
  }

  public function transactionConfirm(Order $order, Request $request)
  {
    $order->update([
      'trans' => true,
      'date_paid' => $request->provider . ' ' . $request->date . ' ' . $request->time,
    ]);

    $reciever = User::find($order->reciever_id);
    $locale = $reciever->country;

    if ($reciever->options['order']) {
      $reciever->notify(new OrderPaid($order->title));
    }
    Mail::to($reciever->email)->queue((new TransactionConfirmed($order, $locale))->onQueue('email_medium'));
    return response()->json($order);
  }

  public function confirmShipping(Order $order, Request $request)
  {
    $order->update([
      'shipped' => true,
      'carrier' => $request->carrier,
      'tracking_number' => $request->tracking_number,
    ]);

    //Decrease stock
    $data = json_decode($order->body);
    DecreaseProduct::dispatch($data)->onQueue('email_low');

    $sender = User::find($order->sender_id);
    $locale = $sender->country;

    if ($sender->options['order']) {
      $sender->notify(new OrderShippedNotification($order->title));
    }
    Mail::to($sender->email)->queue((new OrderShipped($order, $locale))->onQueue('email_medium'));
    return response()->json($data);
  }
}
