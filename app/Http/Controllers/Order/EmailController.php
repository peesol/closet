<?php

namespace Closet\Http\Controllers\Order;

use App;
use Cart;
use Fractal;
use Mail;
use Illuminate\Http\Request;
use Closet\Models\{Order, User, Account};
use Closet\Http\Controllers\Controller;
use Closet\Transformer\OrderTransformer;
use Closet\Mail\{Ordering, OrderConfirmed, TransactionConfirmed, OrderShipped};

class EmailController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Page that open from email.
  |--------------------------------------------------------------------------
  */
  public function confirmPage(Order $order)
  {
    return view('order.confirmation', ['order' => $order]);
  }
  public function confirmedPage()
  {
    return view('order.after.confirmed');
  }
  public function transactionPage(Order $order)
  {
    return view('order.transaction', ['order' => $order]);
  }
  public function shippedPage(Order $order)
  {
    return view('order.shipped', ['order' => $order]);
  }
  /*
  |--------------------------------------------------------------------------
  | Actions from email.
  |--------------------------------------------------------------------------
  | The email version of the confirm action use the same fuction in
  | OrderController.php
  */
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
    return view('order.after.confirmed');
  }
}
