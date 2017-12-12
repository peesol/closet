<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionImage extends Model
{
    protected $fillable = ['collection_id', 'filename'];

     public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function getImage()
    {
      if (!$this->filename){
        return null;
      }

      return config('closet.buckets.images') . '/collection/photo/' . $this->filename;
    }
}
