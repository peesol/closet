<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
      'name',
      'slug',
      'profile_type',
      'description',
      'thumbnail',
      'cover',
      'promotion_points'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
    public function account()
    {
      return $this->hasMany(Account::class);
    }
    public function product()
    {
      return $this->hasMany(Product::class);
    }
    public function used()
    {
      return $this->hasMany(UsedProduct::class);
    }
    public function contact()
    {
      return $this->hasMany(Contact::class);
    }
    public function feedback()
    {
      return $this->hasMany(Feedback::class);
    }
    public function shipping()
    {
      return $this->hasOne(Shipping::class);
    }
    public function post()
    {
      return $this->hasMany(Post::class);
    }
    public function campaign()
    {
      return $this->hasMany(CampaignProduct::class);
    }
    public function getRouteKeyName()
    {
      return 'slug';
    }
    public function getThumbnail()
    {
      if (!$this->thumbnail){
        return config('closet.buckets.images') . '/profile/thumbnail/default.png';
      }

      return config('closet.buckets.images') . '/profile/thumbnail/' . $this->thumbnail;
    }
    public function getCover()
    {
      if (!$this->cover){
        return config('closet.buckets.images') . '/profile/cover/default.jpg';
      }

      return config('closet.buckets.images') . '/profile/cover/' . $this->cover;
    }
    public function collection()
    {
      return $this->hasMany(Collection::class);
    }
    public function showcase()
    {
      return $this->hasMany(Showcase::class);
    }
    public function follows()
    {
      return $this->hasMany(Follow::class);
    }
    public function followCount()
    {
      return $this->follows->count();
    }
    public function productsCount()
    {
      return $this->product->count();
    }
    public function getFollowedProducts()
    {
      return $this->product()->take(5)->orderBy('desc', 'created_at');
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
    public function code()
    {
      return $this->hasMany(Discount::class);
    }
    public function reports()
    {
      return $this->morphMany(Report::class, 'reportable');
    }
}
