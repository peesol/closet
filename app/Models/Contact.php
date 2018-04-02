<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['shop_id', 'type', 'body', 'link', 'show'];

    public function shop()
    {
      return $this->belongsTo(Shop::class);
    }
}
