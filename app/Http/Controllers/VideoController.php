<?php

namespace App\Http\Controllers;

use App\Enums\RetentionType;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //

    public function show(Video $video)
    {
        //TODO: Move to middleware
        $video->addView();

        //TODO: Rewrite
        if($video->retention){
            if($video->retention->type == RetentionType::Views()){
                if($video->retention->value <= $video->views()->count()){
                    dd('denied');
                }
            }
        }
        // show video
        return view('showVideo')->with(['video' => $video]);
    }
}
