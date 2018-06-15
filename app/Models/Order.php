<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
      'sender_id',
      'reciever_id',
      'sender',
      'reciever',
      'uid', 'title',
      'body',
      'confirmed',
      'shipped',
      'trans',
      'feedback',
      'total',
      'shipping',
      'discount',
      'carrier',
      'tracking_number',
      'date_paid',
      'address'
    ];

    public function getRouteKeyname()
    {
      return 'uid';
    }

    public function User()
    {
      return $this->belongsTo(User::class);
    }

}
