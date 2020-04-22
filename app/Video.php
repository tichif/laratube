<?php

namespace Laratube;



class Video extends Model
{
    // this function allows a relationship between video and channel model
    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    // this function check if the user is signed in and if the user is the owner of the video
    public function editable(){
        return auth()->check() && $this->channel->user_id == auth()->user()->id;
    }

    // this function allows a polymorphic relationship
    public function votes(){
        return $this->morphMany(Vote::class,'voteable');
    }

    // this function allows a relationship between video and comment model
    public function comments(){
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }
}
