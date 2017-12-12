<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

	protected $fillable = ['name', 'category_id'];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
    public function type()
    {
    	return $this->hasMany(CategoryType::class);
    }
    public function product()
    {
        return $this->hasMany(Product::class);
    }
    public function translation()
    {
        return $this->hasMany(Translation::class);
    }
    public function translate()
    {
        return $this->translation()->whereNotNull('subcategory_id')->select(['id', 'subcategory_id', 'name']);
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
