<?php

namespace Closet\Filters\Product;

use Closet\Filters\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class MinPriceFilter extends FilterAbstract
{

    public function filter(Builder $builder, $value)
    {
        $value = $this->resolveFilterValue($value);

        if ($value === null) {
            return $builder;
        }

        return $builder->where('price', '>=', $value);
    }
}
