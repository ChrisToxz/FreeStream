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

    protected $casts = [
        'info' => 'object'
    ];

    public static function create(array $attributes = [])
    {
        $attributes['tag'] = Str::random(4);

        $model = static::query()->create($attributes);

        return $model;
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function retention()
    {
        return $this->hasOne(Retention::class);
    }

    public function addView()
    {
        return $this->views()->create();
    }

    public function getOriginalPathAttribute()
    {
        // TODO: Check why I cant use original as column name
        return $this->tag.'/'.$this['original'];
    }
}
