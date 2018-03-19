<?php

namespace Closet;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
}
