<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Video;

class VideosController extends Controller
{
    public function show(Video $video){
        if(request()->expectsJson()){
            return $video;
        }

        return view('pages.videos.show', compact('video'));
    }
}
