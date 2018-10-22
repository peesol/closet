<?php

namespace Closet\Transformer;

use App;
use Date;
use Closet\Models\Order;
use League\Fractal\TransformerAbstract;


class OrderTransformer extends TransformerAbstract
{

	public function transform(Order $order)
	{
		Date::setLocale(App::getLocale());
		return [
		'id' => $order->id,
		'sender' => $order->sender,
		'sender_id' => $order->sender_id,
		'reciever' => $order->reciever_id,
		'uid' => $order->uid,
		'title' => $order->title,
    'body' => $order->body,
    'subtotal' => $order->subtotal,
    'fee' => $order->fee,
    'total' => $order->total,
		'shipping' => $order->shipping,
		'trans' => $order->status['trans'],
		'shipped' => $order->status['shipped'],
		'feedback' => $order->status['feedback'],
		'carrier' => $order->carrier,
		'tracking_number' => $order->tracking_number,
		'address' => $order->address,
		'date_paid' => $order->date_paid,
    'created_at' => Date::parse($order->updated_at)->diffForHumans(),
    'cancled' => (bool) $order->deleted_type != null,
		];
	}

}
