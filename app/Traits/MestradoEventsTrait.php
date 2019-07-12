<?php

namespace PesquisaProjeto\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use PesquisaProjeto\Events\MestradoEvent;

trait MestradoEventsTrait{

    public static function boot()
    {
        parent::boot();

        static::updated(function($mestrado){
            event(new MestradoEvent($mestrado,'updated'));
        });

        static::created(function($mestrado){
            event(new MestradoEvent($mestrado,'created'));
        });

        static::deleting(function($mestrado){
            event(new MestradoEvent($mestrado,'deleted'));
        });
    }
}