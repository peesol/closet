<?php

namespace Closet\Http\Controllers;

use Cart;
use Auth;
use Fractal;
use Mail;
use Closet\Mail\Ordering;
use Illuminate\Http\Request;
use Closet\Models\Message;
use Closet\Transformer\OrderTransformer;

class MessageController extends Controller
{
  public function index()
  {
    return view('message.inbox');
  }

  public function getInbox()
  {
    $id = Auth::user()->id;
    $message = Message::where('reciever_id', $id)->latest()->get();
    return Fractal::collection($message, new OrderTransformer);
  }
  /*ORDER*/
  public function store(Message $message, Request $request)
  {
    $data =[];
    foreach ($request->products as $product) {
      $data[] = array_except($product, ['rowId', 'tax', 'options.shop_id', 'options.shop_name']);
      $id = array_get($product, 'options.shop_id');
    }
    $order = $message->create([
      'sender_id' => $request->sender_id,
      'sender' => $request->sender_name,
      'reciever_id' => $id,
      'reciever' => $request->reciever_name,
      'type' => 'order',
      'title' => 'Order' . ' - ' . $request->sender_name . ' [' . date("d-m-Y", time()) . ']',
      'body' => json_encode($data),
      'total' => $request->total_price,
      'confirmed' => false,
    ]);
    // foreach ($request->products as $product) {
    //   $rowId = array_get($product, 'rowId');
    //   Cart::remove($rowId);
    // }
    $order = Message::findOrFail($order->id);
    $sender = $request->user();

    Mail::to($request->user())->send(new Ordering($order, $sender));

    return response()->json();
  }

  public function confirm(Message $message)
  {
    $message->update([
      'confirmed' => true,
    ]);
    return;
  }
}
