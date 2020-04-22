<?php

namespace Laratube;



class Comment extends Model
{

    protected $appends = ['repliesCount'];

    
    // Laravel will load automatically the user who made the comment
    protected $with = ['user'];

    // this function allows relationship between comment and video models
    public function video(){
        return $this->belongsTo(Video::class);
    }

     // this function allows relationship between comment and user models
     public function user(){
        return $this->belongsTo(User::class);
    }

    // this function allows a polymorphic relationship
    public function votes(){
        return $this->morphMany(Vote::class,'voteable');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'comment_id')->whereNotNull('comment_id');
    }

    public function getRepliesCountAttribute(){
        return $this->replies->count();
    }

}
