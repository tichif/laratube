<?php

namespace Laratube;

use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;


class Channel extends Model implements HasMedia
{

    use HasMediaTrait;

    // This function allows a relationship between the user and channel models
    public function user(){
        return $this->belongsTo(User::class);
    }

    // retrieve the image for this channel
    public function image(){
        if($this->media->first()){
            // pa bliye retire kode sa leu ou heberje
            // return $this->media->first()->getFullUrl('thumb');
            $word = $this->media->first()->getFullUrl('thumb');
            $rest = substr($word,17);
            return 'http://127.0.0.1:8000/'.$rest;
        }

        return null;        
    }

    // this function allows all the conversions we want for this model
    public function registerMediaConversions(Media $media=null){
        $this->addMediaConversion('thumb')
             ->width(100)
             ->height(100);
    }

    // this function allows the correct user to modify his profile
    public function editable(){
        if(!auth()->check()) return false;
        return $this->user_id == auth()->user()->id;
    }

    // this function allows a relationship between channel and subscription model
    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }

    // this function allows a relationship between channel and video model
    public function videos(){
        return $this->hasMany(Video::class);
    }
}
