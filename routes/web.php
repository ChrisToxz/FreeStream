<?php

use App\Models\Video;
use Illuminate\Support\Facades\Route;

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

// TODO: Rewrite routes
//
//Route::middleware('auth')->get('/', function () {
//    $videos = Video::all();
//    return view('dashboard')->with(['videos' => $videos]);
//})->name('dashboard');

Route::get('/test', function(){


////    \Session::push('videos', 'test');
//        dd(\Session::get('videos', []));
//\Session::forget('videos');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::get('/v/{tag}', [\App\Http\Controllers\VideoController::class, 'show'])->middleware('videogate')->name('showvideo'); // show video page
Route::get('/gate', [\App\Http\Controllers\VideoController::class, 'gate'])->name('gate');
Route::post('/gate', [\App\Http\Controllers\VideoController::class, 'gate'])->name('gate');
Route::get('/settings', [\App\Http\Controllers\HomeController::class, 'settings'])->name('settings'); // settingsg page


