<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
//        $videos = Video::all();
        $videos = Video::latest()->paginate(6);
        if($request->ajax()){
            $data = '';
            foreach($videos as $video){
                $data .= '<div class="col" id="'.$video->tag.'">';
                $data .= '<div class="card shadow-sm">';
                $data .= '<a href="'.url('/v/'.$video->tag).'">';
                $data .= '<img class="card-img-top" src="'.asset('/storage/thumbs/'.$video->tag.'.jpg').'" alt="Thumbnail">';
                $data .= '</a>';
                $data .= '<div class="card-body">';
                $data .= '<p class="card-text">'.$video->title.'<small class="text-muted"> - '.$video->duration_string.'</small><br>';
                $data .= '<small class="text-muted">'.$video->created_at.'</small></p>';
                $data .= '<div class="d-flex justify-content-between align-items-center">';
                $data .= '<div class="btn-group">';
                $data .= '<a href="'.url('/e/'.$video->tag).'" class="btn btn-sm btn-outline-secondary" id="button" value="edit">Edit</a>';
                $data .= '<button type="button" class="btn btn-sm btn-outline-danger" id="button" value="delete">Delete</button>';
                $data .= '</div>';
                $data .= '<small class="text-muted">'.round(($video->filesize/1000000),2).' MB - '.$video->views()->count() .'views</small>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
                $data .= '</div>';
            }
            return $data;
        }
        return View::make('index');
    }

    public function load()
    {

    }
}
