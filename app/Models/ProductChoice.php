<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class ProductChoice extends Model
{
    protected $table = 'product_choices';

    protected $fillable = ['product_id', 'name', 'stock'];

    public function product()
    {
      return $this->belongsTo(Product::class);
    }
}
