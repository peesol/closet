<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Showcase extends Model
{
  protected $fillable = ['shop_id','name', 'show', 'order'];
  
  protected $table = 'showcases';

  public function shop()
  {
      return $this->belongsTo(Shop::class);
  }

  public function product()
  {
    return $this->belongsToMany(Product::class, 'showcase_products');
  }

}
