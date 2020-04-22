<?php

namespace Laratube;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    // cancel the default incrementing in authentication by Laravel
    public $incrementing = false;

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = Str::uuid();
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // This function allows a relationship between the user and channel models
    public function channel(){
        return $this->hasOne(Channel::class);
    }

    // 
    public function toggleVote($entity, $type){
        // check if the user already vote
        $vote = $entity->votes->where('user_id', $this->id)->first();

        if($vote){
            // update the vote
            $vote->update([
                'type' => $type
            ]);
            return $vote->refresh();
        }else{
            // create a new vote
           return  $entity->votes()->create([
               'type' => $type,
               'user_id' => $this->id
           ]);
        }

        
    }

    // this function allows a relationship between video and comment model
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
