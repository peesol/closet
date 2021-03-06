<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
      'code',
      'discount',
      'amount',
      'type',
      'used',
    ];
    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }
}
