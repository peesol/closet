<?php

namespace Closet\Traits;

trait Orderable
{

	public function scopeLatestFirst($query)
    {
      return $query->orderBy('created_at', 'desc');
    }

    public function scopePopular($query)
    {
      return $query->where('visibility', 'public')->orderBy('view_count', 'desc');
    }

}
