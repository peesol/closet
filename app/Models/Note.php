<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  protected $fillable = ['product_id', 'shop_id'];

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
  public function product()
  {
    return $this->hasMany(Product::class);
  }
}
