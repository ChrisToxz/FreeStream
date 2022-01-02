<?php

namespace App\Http\Controllers;

use App\Events\videoUploaded;
use App\Events\videoView;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumb;
use App\Models\Video;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Pawlox\VideoThumbnail\VideoThumbnail;

class VideoController extends Controller
{

    public function show($tag){
        //TODO: Event?
        $video = Video::where('tag', $tag)->firstOrFail();
//        $video->increase();
//        event(new videoView($video));
        videoView::dispatch($video);
        return View::make('view')->with('video', $video);
    }
    public function store(StoreVideoRequest $request)
    {
        if ($files = $request->file('file')) {

            $tag = Str::random(4);
            $hash = time().$request->file->hashName();
            $filename = $tag.'-'.$hash;

            $request->file->storeAs('', $filename, 'videos');

            $video = new Video();
            $video->tag = $tag;
            $video->file = $filename;
            $video->title = $files->getClientOriginalName();
            $video->save();
            videoUploaded::dispatch($video);
            //Create thumb
            CreateThumb::dispatchAfterResponse($video);
            //Create stream file

            $job = new ConvertVideoForStreaming($video);
            $this->dispatch($job);
            $video->job_id = $job->getJobStatusId();
            $video->save();

            return Response()->json([
                "success" => true,
                "tag" => $tag,
                "file" => $filename
            ]);

        }

        return Response()->json([
            "success" => false,
            "file" => ''
        ]);

    }

    public function edit($tag){
        $video = Video::byTag($tag);

        return View::make('edit')->with('video', $video);
    }

    public function update(Request $request, $tag){
        if($request->filled('start', 'end')) {
            $video = Video::byTag($tag);
            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries' => 'C:/FFmpeg/bin/ffmpeg.exe',
                'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe',
            ]);
            $ff = $ffmpeg->open(public_path('storage/videos/' . $video->file));

            $ff->filters()->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($request->start), \FFMpeg\Coordinate\TimeCode::fromSeconds($request->end));

            $file_new = preg_match('/' . $video->tag . '-(.*).mp4/', $video->file, $output);

            $file_new = $video->tag . '-' . time() . $output[1] . '.mp4';
            $path_new = 'storage/videos/' . $file_new;
            $ff->save(new \FFMpeg\Format\Video\X264(), public_path($path_new));
            Storage::delete('public/videos/' . $video->file);
            $video->file = $file_new;
            $video->save();
        }
    }

    public function destroy($tag)
    {
        $video = Video::where('tag', $tag)->firstOrFail();
        if($video->delete()){
            return Response()->json([
                "success" => true,
                "tag" => $tag
            ]);
        }
        return Response()->json([
            "success" => false,
            "file" => ''
        ]);
    }
}
