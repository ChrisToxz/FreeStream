<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

use Hashids\Hashids;

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
//    VideoThumbnail::createThumbnail(public_path('storage/videos/5fWq-FKeoch1amOVxXUkA2P4xhhqPT3Sx9Yq7zT5WMvR0.mp4'), public_path('storage/thumbs/'), 'movie2.jpg', 1, 1920, 1080);
//    $getID3 = new \getID3;
//    $file = $getID3->analyze('C:/laragon/www/public/storage/videos/QkwF-oLhj2bJI5N67Qaz9yuCdSkOZQEyeIzdGymLWwAxy.mp4');
//    dd($file);
//    $duration = date('H:i:s.v', $file['playtime_seconds']);
});
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::delete('/delete/{tag}', 'App\Http\Controllers\VideoController@destroy');

Route::get('/v/{tag}', 'App\Http\Controllers\VideoController@show');
Route::post('upload', 'App\Http\Controllers\VideoController@store');
//Route::post('upload', 'App\Http\Controllers\VideoController@store')->middleware('auth');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/', function () {
//    return view('index');
//})->middleware('auth');
