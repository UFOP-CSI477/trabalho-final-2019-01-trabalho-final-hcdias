<?php

namespace PesquisaProjeto\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use PesquisaProjeto\Events\PesquisaEvent;

trait PesquisaEventsTrait{

    public static function boot()
    {
        parent::boot();

        static::updated(function($pesquisa){
            event(new PesquisaEvent($pesquisa,'updated'));
        });

        static::created(function($pesquisa){
            event(new PesquisaEvent($pesquisa,'created'));
        });

        static::deleting(function($pesquisa){
            event(new PesquisaEvent($pesquisa,'deleted'));
        });
    }
}