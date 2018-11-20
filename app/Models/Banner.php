<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
  protected $fillable = [
    'type',
    'filename',
    'link'
  ];

  protected $casts = [
    'filename' => 'object'
  ];

  public function getHomeBanner()
  {
    return $this->where('type', 'home')->get();
  }
}
