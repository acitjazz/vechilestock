<?php

namespace App\Http\Repositories;

use App\Models\Vechile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VechileRepository
{
    const CACHE_KEY = 'VECHILE';

    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['vechiles'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return Vechile::allWithFilters();
        });
    }
    public function find($id)
    {
        $key = "find.{$id}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['vechiles'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($id) {
            return Vechile::find($id);
        });
    }
    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['vechiles'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Vechile::paginateWithFilters($number);
        });
    }

    public function paginateTrash($number)
    {
		request()->merge(['trash' => '1']);
        $keys = $this->requestValue();
        $key = "paginateTrash.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['vechiles'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Vechile::paginateWithFilters($number);
        });
    }

    public function countTrash()
    {
        $key = "countTrash";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['vechiles'])->remember($cacheKey, Carbon::now()->addMonths(6), function (){
            return Vechile::onlyTrashed()->count();
        });
    }
    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return Self::CACHE_KEY . ".$key";
    }

    private function requestValue()
    {
        return http_build_query(request()->all(),'','.');
    }
}
