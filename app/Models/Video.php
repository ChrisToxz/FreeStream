<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Imtigger\LaravelJobStatus\JobStatus;

class Video extends Model
{
    use HasFactory;

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function job(){
        return $this->hasOne(JobStatus::class, 'id', 'job_id');
    }

    public function increase(){
        $view = new View();
        $view->video_id = $this->id;
        $view->save();
    }

    public function updateFile($path){
        $this->file = $path;
    }

    public static function byTag($tag){
        return Video::where('tag', $tag)->firstOrFail();
    }

    public function getFileAttribute(){
        return $this->tag.'-'.$this->hash;
    }

    public function getSizeAttribute($size){
        return round($size/1000000,2);
    }

    public function getDurationStringAttribute(){
        return gmdate("i:s", $this->duration);
    }

    public function getResolutionStringAttribute(){
        $video = json_decode($this->video);
        return $video->resolution_x.' x '.$video->resolution_y;
    }
}
