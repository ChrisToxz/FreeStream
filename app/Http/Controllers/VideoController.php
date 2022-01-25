<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    //

    public function show(Video $video)
    {

        // show video
        return view('showVideo')->with(['video' => $video]);
    }
}
