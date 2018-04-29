<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
}
