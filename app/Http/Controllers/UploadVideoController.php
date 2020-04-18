<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;

class UploadVideoController extends Controller
{
    public function index(Channel $channel){
        return view('pages.channels.upload', compact('channel'));
    }

    public function store(Request $request, Channel $channel){
        return $channel->videos()->create([
            'channel_id' => $channel->id,
            'title' => $request->title,
            'path' => $request->video->store("channel/{$channel->id}/videos")
        ]);
    }
}
