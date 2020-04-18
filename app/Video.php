<?php

namespace Laratube;



class Video extends Model
{
    // this function allows a relationship between video and channel model
    public function channel(){
        return $this->belongsTo(Channel::class);
    }
}
