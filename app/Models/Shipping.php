<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
  protected $fillable = ['shipping_date', 'shipping_promotion', 'shipping_methods'];
  protected $hidden = ['created_at', 'updated_at', 'id'];

  protected $casts = [
    'shipping_date' => 'array',
    'shipping_methods' => 'object',
    'shipping_promotion' => 'array',
  ];

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
}
