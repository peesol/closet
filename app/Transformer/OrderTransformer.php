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
    'total' => number_format($order->total),
		'confirmed' => $order->confirmed,
		'trans' => $order->trans,
		'shipped' => $order->shipped,
		'carrier' => $order->carrier,
		'tracking_number' => $order->tracking_number,
		'address' => $order->address,
		'date_paid' => $order->date_paid,
    'created_at' => Date::parse($order->created_at)->diffForHumans(),
		];
	}

}
