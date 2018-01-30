<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Closet\Filters\Product\ProductFilters;
use Closet\Traits\Orderable;
use Illuminate\Http\Request;

class UsedProduct extends Model
{

  use Orderable;

	protected $fillable = [
      'uid',
      'name',
      'category_id',
      'subcategory_id',
      'type_id',
      'thumbnail',
      'price',
      'description',
      'delete_at',
    ];

    public function shop()
    {
    	return $this->belongsTo(Shop::class);
    }

	  public function category()
    {
    	return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
      return $this->belongsTo(Subcategory::class);
    }
    public function type()
    {
      return $this->belongsTo(CategoryType::class);
    }
    public function collection()
    {
      return $this->belongsToMany(Collection::class, 'collection_products', 'collection_id', 'product_id');
    }
    public function productimages()
    {
      return $this->hasMany(UsedProductImage::class, 'product_id');
    }
     public function getRouteKeyName()
    {
      return 'uid';
    }
    public function getImage()
    {
      return config('closet.buckets.images') . '/used/thumbnail/' . $this->thumbnail;
    }
    public function comments()
    {
      return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }
}
