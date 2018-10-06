<?php

namespace Closet\Models;

//use Laravel\Scout\Searchable;
use Catzilla\ScoutNoindex\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Closet\Filters\Product\ProductFilters;
use Closet\Traits\Orderable;
use Illuminate\Http\Request;

class Product extends Model
{

  use Orderable;
  use Searchable;

	protected $fillable = [
      'uid',
      'name',
      'category_id',
      'subcategory_id',
      'type_id',
      'shop_type',
      'thumbnail',
      'price',
      'discount_price',
      'discount_date',
      'description',
      'visibility',
      'amount',
      'stock',
    ];

    public $hidden = [
      'created_at',
      'updated_at',
    ];

    protected $index = ['name'];

    protected $noindex = [
      'description',
      'stock',
      'amount',
      'updated_at',
      'created_at',
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
      return $this->hasMany(ProductImage::class);
    }
    public function choices()
    {
      return $this->hasMany(ProductChoice::class);
    }
    public function contacts()
    {
      return $this->shop->contact()->get();
    }
    public function views()
    {
      return $this->hasMany(ProductView::class);
    }
    public function campaign()
    {
      return $this->belongsToMany(Campaign::class,'campaign_products', 'product_id', 'campaign_id');
    }
    public function showcase()
    {
      return $this->belongsToMany(Showcase::class, 'showcase_products');
    }
    public function addedToShowcase($showcaseId, $productId)
    {
      return (bool) $this->showcase()->where(['showcase_id' => $showcaseId], ['product_id' => $productId])->count();
    }
    public function viewCount()
    {
      return $this->views->count();
    }
     public function getRouteKeyName()
    {
      return 'uid';
    }
    public function ownedByUser(User $user)
    {
      return $this->shop->user->id === $user->id;
    }
    public function votes()
    {
      return $this->morphMany(Vote::class, 'voteable');
    }
    public function upVotes()
    {
      return $this->votes->where('type','up');
    }
    public function downVotes()
    {
      return $this->votes->where('type','down');
    }
    public function voteFromUser(User $user)
    {
      return $this->votes->where('user_id', $user->id);
    }
    public function comments()
    {
      return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }
    public function reports()
    {
      return $this->morphMany(Report::class, 'reportable');
    }
    public function getImage()
    {
      return config('closet.buckets.images') . '/product/thumbnail/' . $this->thumbnail;
    }
    public function scopeFilter(Builder $builder, Request $request, array $filters = [])
    {
      return (new ProductFilters(request()))->add($filters)->filter($builder);
    }
    public function shouldBeSearchable()
    {
        return $this->visibility == 'public';
    }
    public function toSearchableArray()
    {
        return [
          'id' => $this->id,
          'category_id' => $this->category_id,
          'subcategory_id' => $this->subcategory_id,
          'type_id' => $this->type_id,
          'shop_type' => $this->shop_type,
          'uid' => $this->uid,
          'name' => $this->name,
          'price' => $this->price,
          'discount_date' => $this->discount_date,
          'discount_price' => $this->discount_price,
          'thumbnail' => $this->thumbnail
        ];
    }
}
