<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function views()
    {
        return $this->hasMany(View::class);
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
}
