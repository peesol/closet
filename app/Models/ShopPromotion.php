<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPromotion extends Model
{
    protected $fillable = ['discount', 'get_another', 'flash_sale'];
    protected $table = 'shop_promotions';

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }
}
