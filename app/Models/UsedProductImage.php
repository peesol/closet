<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class UsedProductImage extends Model
{
    protected $fillable = ['product_id', 'filename'];

    public function product()
    {
    	return $this->belongsTo(UsedProduct::class);
    }

    public function getImage()
    {
      if (!$this->filename){
        return null;
      }
      return config('closet.buckets.images') . '/used/photo/' . $this->filename;
    }
}
