<?php

namespace PesquisaProjeto\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use PesquisaProjeto\Events\TccEvent;

trait TccEventsTrait{

    public static function boot()
    {
        parent::boot();

        static::updated(function($pesquisa){
            event(new TccEvent($pesquisa,'updated'));
        });

        static::created(function($pesquisa){
            event(new TccEvent($pesquisa,'created'));
        });

        static::deleting(function($pesquisa){
            event(new TccEvent($pesquisa,'deleted'));
        });
    }
}