<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{

  public $timestamps = false;
  
    public function subcategory()
    {
    	return $this->belongsTo(Subcategory::class);
    }
    public function translation()
    {
        return $this->hasMany(Translation::class);
    }
    public function translate()
    {
        return $this->translation()->whereNotNull('category_type_id')->select(['id','category_type_id','name']);
    }
    public function showTranslate($lang)
		{
			if($lang == 'en'){
				return $this;
			} else {
				return $this->translation()->where('language', $lang)->first();
			}
		}
}
