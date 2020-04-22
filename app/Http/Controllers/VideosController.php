<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Http\Requests\Videos\UpdateVideoRequest;
use Laratube\Video;

class VideosController extends Controller
{
    public function show(Video $video){
        if(request()->expectsJson()){
            return $video;
        }
        
        return view('pages.videos.show', compact('video'));
    }

    public function updateViews(Video $video){
        $video->increment('views');

        return response()->json([]);
    }

    public function update(UpdateVideoRequest $request,Video $video){
        $video->update($request->only(['title','description']));

        return redirect()->back();
    }
}
