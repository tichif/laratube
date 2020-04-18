<?php

namespace Laratube\Http\Controllers;

use Illuminate\Http\Request;
use Laratube\Channel;
use Laratube\Subscription;

class SubscriptionsController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function store(Channel $channel)
    {
       return  $channel->subscriptions()->create([
            'user_id' => auth()->user()->id,
            'channel_id' => $channel->id,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Channel  $channel
     * @param  Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();

        return response()->json([]);
    }
}
