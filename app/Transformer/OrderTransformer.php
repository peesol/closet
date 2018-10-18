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
    'body' => json_decode($order->body),
    'subtotal' => $order->subtotal,
    'fee' => $order->fee,
    'total' => $order->total,
		'shipping' => json_decode($order->shipping),
		'trans' => $order->trans,
		'shipped' => $order->shipped,
		'feedback' => $order->feedback,
		'carrier' => $order->carrier,
		'tracking_number' => $order->tracking_number,
		'address' => $order->address,
		'date_paid' => $order->date_paid,
    'created_at' => Date::parse($order->updated_at)->diffForHumans(),
    'cancled' => (bool) $order->deleted_type != null,
		];
	}

}
