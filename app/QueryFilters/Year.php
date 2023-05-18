<?php

namespace App\QueryFilters;

use Closure;

class Year extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('year',(int)request($this->filterName()));
   }
}
