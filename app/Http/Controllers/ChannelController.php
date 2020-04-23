<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Http\Requests\Channels\UpdateRequest;
use Laratube\Channel;

class ChannelController extends Controller
{

    public function __construct(){
        $this->middleware(['auth'])->only('update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $videos = $channel->videos()->paginate(5);
        return view('pages.channels.show', compact('channel','videos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Channel $channel)
    {
        if($request->hasFile('image')){
            // delete old pictures in collection
            $channel->clearMediaCollection('images');
            // add picture in collection
            $channel->addMediaFromRequest('image')
                    ->toMediaCollection('images');
        }

        $channel->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
