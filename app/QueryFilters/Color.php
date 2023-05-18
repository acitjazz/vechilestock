<?php

namespace App\QueryFilters;

use Closure;

class Color extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('color', request($this->filterName()));
   }
}
