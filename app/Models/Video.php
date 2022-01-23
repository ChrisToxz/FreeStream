<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function create(array $attributes = [])
    {
        $attributes['tag'] = Str::random(4);

        $model = static::query()->create($attributes);

        return $model;
    }
}
