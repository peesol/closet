<?php

namespace Closet\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','email_token','can_sell','phone','address','country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function shop()
    {
      return $this->hasOne(Shop::class);
    }

    public function usertype()
    {
      return $this->hasOne(Usertype::class);
    }
    public function account()
    {
      return $this->hasManyThrough(Account::class, Shop::class);
    }
    public function products()
    {
      return $this->hasManyThrough(Product::class, Shop::class);
    }

    public function showcase()
    {
      return $this->hasManyThrough(Showcase::class, Shop::class)->orderBy('order', 'asc');
    }

    public function used()
    {
      return $this->hasManyThrough(UsedProduct::class, Shop::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function followedShops()
    {
        return $this->belongsToMany(Shop::class, 'follows');
    }

    public function isFollow(Shop $shop)
    {
        return (bool) $this->follows->where('shop_id', $shop->id)->count();
    }
    public function ownsShop(Shop $shop)
    {
        return (bool) $this->shop()->where('id', $shop->id)->first();
    }

    public function canSell()
    {
        return (bool) $this->can_sell == true;
    }
}
