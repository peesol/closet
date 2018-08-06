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
}
