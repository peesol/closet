<?php

namespace Closet\Http\Controllers\Order;

use App;
use Cart;
use Auth;
use Fractal;
use Mail;
use Illuminate\Http\Request;
use Closet\Http\Controllers\Controller;
use Closet\Models\{Order, User, Account};
use Closet\Transformer\OrderTransformer;
use Closet\Mail\{Ordering, OrderConfirmed, TransactionConfirmed, OrderShipped};

class OrderController extends Controller
{
  public function sellingPage()
  {
    return view('order.selling');
  }
  public function buyingPage()
  {
    return view('order.buying');
  }
  /*
  |--------------------------------------------------------------------------
  | Ajax
  |--------------------------------------------------------------------------
  */
  public function getSellingInbox()
  {
    $id = Auth::user()->id;
    $order = Order::where('reciever_id', $id)->latest()->get();
    return Fractal::collection($order, new OrderTransformer);
  }
  public function getBuyingInbox()
  {
    $id = Auth::user()->id;
    $order = Order::where('sender_id', $id)->latest()->get();
    return Fractal::collection($order, new OrderTransformer);
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
      'uid' => uniqid(true). $request->user()->id . date("dmY_His", time()),
      'title' => 'Order' . ' - ' . $request->sender_name . ' [' . date("d-m-Y", time()) . ']',
      'body' => json_encode($data),
      'total' => (int)str_replace(',', '', $request->total_price),
      'discount' => $request->discount,
    ]);
    foreach ($request->products as $product) {
      $rowId = array_get($product, 'rowId');
      Cart::remove($rowId);
    }
    $reciever = User::find($order->reciever_id);
    if ($reciever->country == 'ไทย') {
      $locale = 'th';
    } else {
      $locale = 'en';
    }

    Mail::to($reciever->email)->queue(new Ordering($order, $locale));

    return response()->json($locale);
  }
  public function confirm(Order $order, Request $request)
  {
    $order->update([
      'confirmed' => true,
      'free_shipping' => $request->shipping,
      'shipping_fee' => $request->shipping_fee ? $request->shipping_fee : null,
    ]);
    $accounts = Account::where('shop_id', $order->reciever_id)->get();
    $sender = User::find($order->sender_id);
    if ($sender->country == 'ไทย') {
      $locale = 'th';
    } else {
      $locale = 'en';
    }

    Mail::to($sender->email)->queue(new OrderConfirmed($order, $accounts, $locale));

    return response()->json(null, 200);
  }
  public function deny(Order $order)
  {
    $order->delete();
    return;
  }
  public function transactionConfirm(Order $order, Request $request)
  {
    $order->update(['trans' => true]);
    $data = [
      'date' => $request->date,
      'time' => $request->time,
      'name' => $request->name,
      'address' => $request->address,
      'phone' => $request->phone,
    ];
    $reciever = User::find($order->$reciever_id);
    if ($reciever->country == 'ไทย') {
      $locale = 'th';
    } else {
      $locale = 'en';
    }
    Mail::to($reciever->email)->queue(new TransactionConfirmed($order, $data, $locale));
    return view('order.after.transaction');
  }

  public function confirmShipping(Order $order, Request $request)
  {
    $order->update(['shipped' => true]);
    $data = [
      'carrier' => $request->carrier,
      'tracking_number' => $request->tracking_number,
    ];
    $sender = User::find($order->$sender_id);
    if ($sender->country == 'ไทย') {
      $locale = 'th';
    } else {
      $locale = 'en';
    }
    Mail::to($sender->email)->send(new OrderShipped($order, $data, $locale));
    return;
  }
}