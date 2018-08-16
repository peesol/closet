<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

  protected $fillable = [
    'user_id',
    'title',
    'body'
  ];

  public function reportable()
  {
    return $this->morphTo();
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
