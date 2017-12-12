<?php

namespace Closet\Filters\Product;

use Closet\Filters\FiltersAbstract;

use Closet\Filters\Product\{
    CategoryFilter,
    SubategoryFilter,
    TypeFilter,
    PriceFilter
};

class ProductFilters extends FiltersAbstract
{
    /**
     * Default course filters.
     *
     * @var array
     */
    protected $filters = [
      'c' => CategoryFilter::class,
      'sub' => SubcategoryFilter::class,
      'type' => TypeFilter::class,
      'min' => MinPriceFilter::class,
      'max' => MaxPriceFilter::class
    ];

}
