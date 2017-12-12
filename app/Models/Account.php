<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name', 'provider_name', 'provider', 'number'];
    public function user()
    {
      return $this->belongsTo(Shop::class);
    }
}
