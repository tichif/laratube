<?php

namespace Laratube;



class Channel extends Model
{
    // This function allows a relationship between the user and channel models
    public function user(){
        return $this->belongsTo(User::class);
    }
}
