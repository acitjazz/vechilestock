<?php

namespace App\QueryFilters;

use Closure;

class ModelId extends Filter
{
   protected function applyFilter($builder)
   {
      return $builder->where('model_id', request($this->filterName()));
   }
}
