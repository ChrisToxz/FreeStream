<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'tag';
    public $incrementing = false;
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    public static function create(array $attributes = [])
    {
        $attributes['tag'] = Str::random(4);

        $model = static::query()->create($attributes);

        return $model;
    }
}
