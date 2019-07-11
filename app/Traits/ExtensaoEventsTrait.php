<?php

namespace PesquisaProjeto\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use PesquisaProjeto\Events\ExtensaoEvent;

trait ExtensaoEventsTrait{

    public static function boot()
    {
        parent::boot();

        static::updated(function($extensao){
            event(new ExtensaoEvent($extensao,'updated'));
        });

        static::created(function($extensao){
            event(new ExtensaoEvent($extensao,'created'));
        });

        static::deleting(function($extensao){
            event(new ExtensaoEvent($extensao,'deleted'));
        });
    }
}