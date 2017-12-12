<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'category_translation';

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
}
