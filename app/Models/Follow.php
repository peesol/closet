<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
    	'shop_id',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
