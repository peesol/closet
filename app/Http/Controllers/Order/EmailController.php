<?php

namespace Closet\Http\Controllers\Order;

use DB;
use App;
use Cart;
use Fractal;
use Mail;
use Illuminate\Http\Request;
use Closet\Models\{Order, User, Account};
use Closet\Http\Controllers\Controller;
use Closet\Transformer\OrderTransformer;
use Closet\Jobs\Product\DecreaseProduct;
use Closet\Mail\{Ordering, OrderConfirmed, TransactionConfirmed, OrderShipped, OrderDeny, OrderCancle};
use Closet\Notifications\Seller\{OrderPlaced, OrderCancled, OrderPaid};
use Closet\Notifications\Buyer\{OrderDenied, OrderShippedNotification};

class EmailController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Page that open from email.
  |--------------------------------------------------------------------------
  */
  // public function confirmPage(Order $order)
  // {
  //   return view('order.email.confirmation', ['order' => $order]);
  // }
  public function confirmedPage()
  {
    return view('order.after.confirmed');
  }

  public function transactionPage(Order $order)
  {
    if (!$order->status['trans']) {
      $accounts = Account::where('shop_id', $order->reciever_id)->get();

      return view('order.email.transaction', [
        'order' => $order,
        'accounts' => $accounts
      ]);
    } else {
      return view('order.after.success', ['message' => __('message.already_transacted')]);
    }
  }

  public function shippedPage(Order $order)
  {
    return view('order.email.shipped', ['order' => $order]);
  }

  public function denyPage(Order $order)
  {
    if (!$order->status['trans'] || !$order->status['shipped']) {
      return view('order.email.deny', ['order' => $order]);
    } else {
      return view('order.after.error', ['message' => __('message.order_undeniable')]);
    }
  }

  public function canclePage(Order $order)
  {
    if (!$order->status['trans']) {
      return view('order.email.cancle', ['order' => $order]);
    } else {
      return view('order.after.error', ['message' => __('message.order_undeniable')]);
    }
  }
  /*
  |--------------------------------------------------------------------------
  | Actions from email.
  |--------------------------------------------------------------------------
  | The email version of the confirm action use the same fuction in
  | OrderController.php
  */
  // public function confirm(Order $order, Request $request)
  // {
  //   $order->update([
  //     'confirmed' => true,
  //     'shipping_fee' => $request->shipping_fee
  //   ]);
  //   $accounts = Account::where('shop_id', $order->reciever_id)->get();
  //   $sender = User::find($order->sender_id);
  //   $locale = $sender->country;
  //
  //   Mail::to($sender->email)->queue(new OrderConfirmed($order, $accounts, $locale));
  //
  //   return response()->json(null, 200);
  // }
  // public function deny(Order $order)
  // {
  //   $order->delete();
  //   return;
  // }
  public function transactionConfirm(Order $order, Request $request)
  {
    DB::table('orders')->where('id', $order->id)->update([
      'status->trans' => true,
      'date_paid' => $request->provider . ' ' . $request->date . ' ' . $request->time,
    ]);

    $reciever = User::find($order->reciever_id);
    $locale = $reciever->country;

    if ($reciever->where('options->order', true)) {
      $reciever->notify(new OrderPaid($order->title));
    }

    Mail::to($reciever->email)->queue((new TransactionConfirmed($order, $locale))->onQueue('email'));
    return redirect()->back();
  }

  public function confirmShipping(Order $order, Request $request)
  {
    DB::table('orders')->where('id', $order->id)->update([
      'status->shipped' => true,
      'carrier' => $request->carrier,
      'tracking_number' => $request->tracking_number,
    ]);

    $sender = User::find($order->sender_id);
    $locale = $sender->country;

    $data = json_decode($order->body);
    DecreaseProduct::dispatch($data)->onQueue('low');

    if ($sender->where('options->order', true)) {
      $sender->notify(new OrderShippedNotification($order->title));
    }

    Mail::to($sender->email)->queue((new OrderShipped($order, $locale))->onQueue('email'));
    return redirect()->back();
  }

  public function deny(Order $order, Request $request)
  {
    if (!$order->status['trans']) {
      $order->update([
        'deleted_type' => 1
      ]);
      $order->delete();

      $sender = User::find($order->sender_id);
      $locale = $sender->country;

      if ($sender->where('options->order', true)) {
        $sender->notify(new OrderDenied($order->title));
      }

      Mail::to($sender->email)->queue((new OrderDeny($order, $locale, $request->textarea))->onQueue('low'));

      return redirect()->route('orderDeleted');
    }
  }
  public function cancle(Order $order)
  {
    if (!$order->status['trans']) {
      $order->update([
        'deleted_type' => 2
      ]);
      $order->delete();

      $reciever = User::find($order->reciever_id);
      $locale = $reciever->country;
      $contact = $reciever->email . ' / ' . $reciever->phone;

      if ($reciever->where('options->order', true)) {
        $reciever->notify(new OrderCancled($order->title));
      }

      Mail::to($reciever->email)->queue((new OrderCancle($order, $locale, $contact))->onQueue('low'));

      return redirect()->route('orderDeleted');
    }
  }

  public function deletedView()
  {
    return view('order.after.error', ['message' => __('message.order_deleted')]);
  }
}
