<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Pipeline\Pipeline;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    protected $connection = 'mongodb';
    protected $collection = 'users';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function paginateWithFilters($limit)
    {
        return app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\SearchName::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->paginate($limit);
    }

    public static function allWithFilters()
    {
        return app(Pipeline::class)
            ->send(User::query())
            ->through([
                \App\QueryFilters\SortBy::class,
                \App\QueryFilters\SearchName::class,
                \App\QueryFilters\Trash::class,
            ])
            ->thenReturn()
            ->get();
    }
}
