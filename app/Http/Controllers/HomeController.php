<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\SlipstreamSettings;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $videos = Video::latest()->get();
        return view('dashboard')->with(['videos' => $videos]);
    }

    public function settings(SlipstreamSettings $settings)
    {
        return view('settings');
    }
}
