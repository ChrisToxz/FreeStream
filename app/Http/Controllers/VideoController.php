<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Hashids\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Pawlox\VideoThumbnail\VideoThumbnail;

class VideoController extends Controller
{

    public function show($tag){
        //TODO: Event?
        $video = Video::where('tag', $tag)->firstOrFail();
        $video->increase();
        return View::make('view')->with('video', $video);
    }
    public function store(Request $request)
    {
        request()->validate([
            'file'  => 'required|mimes:mp4|max:1024000',
        ]);

        if ($files = $request->file('file')) {
            $getID3 = new \getID3;
            $data = $getID3->analyze($files);

            $tag = Str::random(4);
            $filename = $tag.'-'.$request->file->hashName();

            $file = $request->file->storeAs('public/videos', $filename);

            $video = new Video();
            $video->file = $filename;
            $video->tag = $tag;
            $video->duration = $data["playtime_seconds"];
            $video->duration_string = $data["playtime_string"];
            $video->filesize = $data["filesize"];
            $video->video = json_encode($data["video"]);
            $video->title = $files->getClientOriginalName();
            $video->save();

            //TODO: Processing job
            (new \Pawlox\VideoThumbnail\VideoThumbnail)->createThumbnail(public_path('storage/videos/'.$filename), public_path('storage/thumbs/'), $tag.'.jpg', 1, 1920, 1080);

            return Response()->json([
                "success" => true,
                "tag" => $tag,
                "file" => $file
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
