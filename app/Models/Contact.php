<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['shop_id', 'type', 'body', 'link', 'show_cover', 'show_product'];

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }
}
