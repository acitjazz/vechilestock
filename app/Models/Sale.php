<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Pipeline\Pipeline;

class Sale extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'sales';

    protected $fillable = [
        'vechile_id',
        'model_id',
        'type',
        'year',
        'price',
        'color',
        'qty',
    ];


    protected $casts = [
        'type'       =>  'string',
        'color'       =>  'string',
        'year'       =>  'integer',
        'qty'       =>  'integer',
        'price'       =>  'float',
    ];

    public function setYearAttribute($year){
        $this->attributes['year'] = (int)$year;
    }


    public function setQtyAttribute($qty){
        $this->attributes['qty'] = (int)$qty;
    }


    public function setPriceAttribute($price){
        $this->attributes['price'] = floatval($price);
    }

    public function car()
    {
        return $this->belongsTo(Car::class,'model_id');
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class,'model_id');
    }

    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(Sale::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\ModelId::class,
                \App\QueryFilters\VechileId::class,
                \App\QueryFilters\Month::class,
                \App\QueryFilters\Color::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->paginate($limit);
    }

    public static function allWithFilters()
    {
        return app(Pipeline::class)
            ->send(Sale::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\ModelId::class,
                \App\QueryFilters\VechileId::class,
                \App\QueryFilters\Month::class,
                \App\QueryFilters\Color::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->get();
    }
}
