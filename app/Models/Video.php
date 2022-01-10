<?php

namespace App\Models;

use App\Enums\VideoType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Imtigger\LaravelJobStatus\JobStatus;

class Video extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $primaryKey = 'tag';
    public $incrementing = false;
    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';

    protected $casts = [
        'files' => 'object',
    ];

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
        if(!empty($this->job->is_finished)){
            return $this->job->is_finished;
        }
        if($this->type == VideoType::Original()){
            return 1;
        }
        return 0;
    }
}
