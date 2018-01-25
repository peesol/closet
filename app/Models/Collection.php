<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;
use Closet\Models\User;
use Closet\Traits\Orderable;

class Collection extends Model
{
  use Orderable;

	protected $fillable = [
      'name',
      'slug',
      'visibility',
      'description',
      'image_filename',
    ];

    public function shop()
    {
    	return $this->belongsTo(Shop::class);
    }

    public function products()
    {
    	return $this->belongsToMany(Product::class, 'collection_products', 'collection_id', 'product_id');
    }

    public function images()
    {
    	return $this->hasMany(CollectionImage::class);
    }
    public function getRouteKeyName()
    {
      return 'slug';
    }

    public function getImage()
    {
      if (!$this->thumbnail){
        return config('closet.buckets.images') . '/collection/thumbnail/default.jpg';
      }

      return config('closet.buckets.images') . '/collection/thumbnail/' . $this->thumbnail;
    }

    public function ownedByUser(User $user)
    {
      return $this->shop->user_id === $user->id;
    }

    public function addedToCollection($productId)
    {
      return (bool) $this->products()->where('product_id', $productId)->count();
    }
}
