<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;


class Car extends Eloquent
{
    use HasFactory;
    use SoftDeletes;
    protected $connection = 'mongodb';
    protected $collection = 'cars';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'machine',
        'passenger',
        'type',
    ];

    protected $casts = [
        'machine'       =>  'string',
        'passenger'       =>  'integer',
        'type'       =>  'string',
    ];

    public function setPassengerAttribute($passenger){
        $this->attributes['passenger'] = (int)$passenger;
    }

    public function vechiles()
    {
        return $this->hasMany(Vechile::class,'model_id');
    }


    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(Car::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->paginate($limit);
    }

    public static function allWithFilters()
    {
        return app(Pipeline::class)
            ->send(Car::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\Type::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->get();
    }
}
