<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Imtigger\LaravelJobStatus\JobStatus;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function job(){
        return $this->hasOne(JobStatus::class);
    }

    public function getOriginalPathAttribute(){
        return $this->tag.'/'.$this->hash;
    }

    public function getProgressNowAttribute(){
        return $this->job->progress_now ?? "x";
    }
}
