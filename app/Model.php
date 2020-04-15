<?php

namespace Laratube;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Str;

class Model extends BaseModel
{

    // Turn mass assignable OFF
    protected $guarded = [];

    // cancel the default incrementing in authentication by Laravel
    public $incrementing = false;

    protected static function boot(){
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = Str::uuid();
        });
    }
}
