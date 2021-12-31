<?php

use App\Models\Video;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

use Hashids\Hashids;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function(){

    $media = FFMpeg::fromDisk('public')->open('videos/IXAe-1640974459HaSFMH3n1lgfLbLhUsnadTjy6fs18XEo4Q0D3WIb.mp4');
    dd($media->getStreams());
    dd();
    dump(FFMpeg::fromDisk('public')->open('videos/IXAe-1640974459HaSFMH3n1lgfLbLhUsnadTjy6fs18XEo4Q0D3WIb.mp4')->getFrameFromSeconds(0.1)->export()->toDisk('public')->save('thumbs/test.jpg'));
//    $tag = '0gFp';
//    $video = Video::byTag($tag);
//
//    $ffmpeg = FFMpeg\FFMpeg::create([
//        'ffmpeg.binaries'  => 'C:/FFmpeg/bin/ffmpeg.exe',
//        'ffprobe.binaries' => 'C:/FFmpeg/bin/ffprobe.exe',
//        ]);
//    $ff = $ffmpeg->open(public_path('storage/videos/'.$video->file));
//
//    $ff->filters()->clip(FFMpeg\Coordinate\TimeCode::fromSeconds(0), FFMpeg\Coordinate\TimeCode::fromSeconds(3));
//    $ff->save(new FFMpeg\Format\Video\X264(), public_path('storage/videos/edit'.$video->file));
//    Storage::delete('public/videos/'.$video->file);
//    VideoThumbnail::createThumbnail(public_path('storage/videos/uNGZ-xAiUKsor6TVXxPXRJj1D9wE7Zvy5hEsmK8qW3KBU.mp4'), public_path('storage/thumbs/'), 'movie2.jpg', 1, 1920, 1080);
//    $getID3 = new \getID3;
//    $file = $getID3->analyze('C:/laragon/www/public/storage/videos/QkwF-oLhj2bJI5N67Qaz9yuCdSkOZQEyeIzdGymLWwAxy.mp4');
//    dd($file);
//    $duration = date('H:i:s.v', $file['playtime_seconds']);
});
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::delete('/delete/{tag}', 'App\Http\Controllers\VideoController@destroy');

Route::get('/v/{tag}', 'App\Http\Controllers\VideoController@show');
Route::get('/e/{tag}', 'App\Http\Controllers\VideoController@edit');
Route::post('/e/{tag}', 'App\Http\Controllers\VideoController@update');
Route::post('upload', 'App\Http\Controllers\VideoController@store');
//Route::post('upload', 'App\Http\Controllers\VideoController@store')->middleware('auth');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/', function () {
//    return view('index');
//})->middleware('auth');
