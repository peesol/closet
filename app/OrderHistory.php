<?php

namespace Closet;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
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
