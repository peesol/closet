<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'sender_id',
      'reciever_id',
      'sender',
      'reciever',
      'uid', 'title',
      'body',
      'confirmed',
      'status',
      'subtotal',
      'total',
      'fee',
      'shipping',
      'discount',
      'carrier',
      'tracking_number',
      'date_paid',
      'address',
      'deleted_type'
    ];
    protected $casts = [
      'status' => 'array',
      'body' => 'array',
      'shipping' => 'array'
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
