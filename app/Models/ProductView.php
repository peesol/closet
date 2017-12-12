<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class ProductView extends Model
{
	protected $fillable = [
      'product_id',
      'user_id',
      'ip',
    ];

    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
