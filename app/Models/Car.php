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
