<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Imtigger\LaravelJobStatus\JobStatus;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'tag';
    public $incrementing = false;
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    public function job(){
        return $this->hasOne(JobStatus::class);
    }

    public function getOriginalPathAttribute(){
        return $this->tag.'/'.$this->hash;
    }

    public function getProgressNowAttribute(){
        return $this->job->progress_now ?? "x";
    }

    public function getFinishedAttribute(){
        return isset($this->job->is_finished) ?? false;
    }
}
