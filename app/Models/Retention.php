<?php

namespace App\Models;

use App\Enums\RetentionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retention extends Model
{
    use HasFactory;

    protected $casts = [
        'user_type' => RetentionType::class, // Example enum cast
    ];

    public function video(){
        return $this->belongsTo(Video::class);
    }
}
