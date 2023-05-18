<?php

namespace App\QueryFilters;

use Closure;

class VechileId extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('vechile_id', request($this->filterName()));
   }
}
