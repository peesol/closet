<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
  protected $fillable = ['shop_id', 'product_id', 'price', 'discont_price'];

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
}
