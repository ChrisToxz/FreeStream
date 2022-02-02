<?php

namespace App\Http\Middleware;

use App\Models\Video;
use Closure;
use Illuminate\Http\Request;

class VideoGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if(Video::findByTag($request->tag)){
            if(in_array($request->tag, \Session::get('videos', []))){
                return $next($request);
            }else{
                \Session::put('current-video', $request->tag);
                return redirect()->route('gate');
            }
        }
    }
}
