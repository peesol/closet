<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
  protected $fillable = ['shop_id', 'product_id', 'campaign_id'];

  protected $table = 'campaign_products';

  public $timestamps = false;

  public function shop()
  {
    return $this->belongsTo(Shop::class);
  }
}
