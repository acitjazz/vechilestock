<?php

namespace App\Http\Repositories;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SaleRepository
{
    const CACHE_KEY = 'SALE';

    public function all()
    {
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['sales'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {
            return Sale::allWithFilters();
        });
    }
    public function find($id)
    {
        $key = "find.{$id}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['sales'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($id) {
            return Sale::find($id);
        });
    }

    public function statistic()
    {
        cache()->flush();
        $keys = $this->requestValue();
        $key = "all.{$keys}}";
        $cacheKey = $this->getCacheKey($key);
        return Cache::tags(['sales'])->remember($cacheKey, Carbon::now()->addMonths(6), function () {


            $sales =  Sale::allWithFilters();
            return [
                'motorcycle' => [
                    'total' => $sales->where('type','Motorcycle')->count(),
                    'provit' => $sales->where('type','Motorcycle')->sum('price'),
                    'variants' => $sales->where('type','Motorcycle')->groupBy('model_id')->map(function($data){
                        return [
                            'color' => $data->first()->color,
                            'transmission' => $data->first()->motorcycle->transmission ?? null,
                            'suspension' => $data->first()->motorcycle->suspension ?? null,
                            'machine' => $data->first()->motorcycle->machine  ?? null,
                            'total' => $data->count(),
                        ];
                    }),
                ],
                'car' => [
                    'total' => $sales->where('type','Car')->count(),
                    'provit' => $sales->where('type','Car')->sum('price'),
                    'variants' => $sales->where('type','Car')->groupBy('model_id')->map(function($data){
                        return [
                            'color' => $data->first()->color,
                            'passenger' => $data->first()->car->passenger  ?? null,
                            'type' => $data->first()->car->type  ?? null,
                            'machine' => $data->first()->car->machine  ?? null,
                            'total' => $data->count(),
                        ];
                    }),
                ],
            ];
        });
    }

    public function paginate($number)
    {
        $keys = $this->requestValue();
        $key = "paginate.{$number}.{$keys}";
        $cacheKey = $this->getCacheKey($key);

        return Cache::tags(['sales'])->remember($cacheKey, Carbon::now()->addMonths(6), function () use ($number) {
            return Sale::paginateWithFilters($number);
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
