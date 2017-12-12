<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'filename'];

     public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getImage()
    {
      return config('closet.buckets.images') . '/product/photo/' . $this->filename;
    }
}
