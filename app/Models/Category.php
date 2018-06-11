<?php

namespace Closet\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'categories';

	protected $fillable = ['name'];

	public $timestamps = false;

		public function getRouteKeyName()
 		{
	 		return 'slug';
 		}
    public function product()
    {
    	return $this->hasMany(Product::class);
    }
    public function subcategory()
    {
    	return $this->hasMany(Subcategory::class);
    }
    public function type()
    {
    	return $this->hasManyThrough(CategoryType::class, Subcategory::class);
    }
     public function translation()
    {
        return $this->hasMany(Translation::class);
    }
    public function translate()
    {
        return $this->translation()->whereNotNull('category_id')->select(['id', 'category_id', 'name']);
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
