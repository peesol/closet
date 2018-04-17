<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
  protected $fillable = ['giver_id', 'points', 'comment'];
  protected $table = 'feedback';

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }

  public function giver()
  {
    return $this->belongsTo(Shop::class, 'giver_id');
  }
}
