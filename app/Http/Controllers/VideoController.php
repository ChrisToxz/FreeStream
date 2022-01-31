<?php

namespace App\Http\Controllers;

use App\Enums\RetentionType;
use App\Models\Video;
use App\SlipstreamSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //

    public function show($tag, SlipstreamSettings $settings)
    {
        $video = Video::findByTag($tag);
        //TODO: Move to middleware
        $video->addView();

        //TODO: Rewrite + middleware
        if($video->retention){
            if($video->retention->type == RetentionType::Views()){
                if($video->retention->value < $video->views()->count()){
                    // Last visitor

                    $video->retention()->update([
                        'type' => RetentionType::Datetime(),
                        'value' => Carbon::now()->addMinutes(3)->toDateTimeLocalString()
                    ]);
                    $video->save();
                }
            }
        }
        // show video
        return view('showVideo')->with(['video' => $video, 'settings' => $settings]);
    }
}
