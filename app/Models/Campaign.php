<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
  protected $fillable = ['campaign', 'rules'];

  public $timestamps = false;

  public function campaignProduct()
  {
    return $this->hasMany(CampaignProduct::class);
  }
  public function products()
  {
    return $this->belongsToMany(Product::class, 'campaign_products', 'campaign_id', 'product_id');
  }
}
