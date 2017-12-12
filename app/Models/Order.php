<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['sender_id', 'reciever_id', 'sender', 'reciever', 'uid', 'title', 'body', 'confirmed', 'shipped', 'trans', 'total', 'free_shipping','shipping_fee'];

    public function getRouteKeyname()
    {
      return 'uid';
    }

    public function User()
    {
      return $this->belongsTo(User::class);
    }

}
