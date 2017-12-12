<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Usertype extends Model
{

	protected $fillable = ['name'];
	
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}