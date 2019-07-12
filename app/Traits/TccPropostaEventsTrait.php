<?php

namespace PesquisaProjeto\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use PesquisaProjeto\Events\TccPropostaEvent;

trait TccPropostaEventsTrait{

    public static function boot()
    {
        parent::boot();

        static::updated(function($pesquisa){
            event(new TccPropostaEvent($pesquisa,'updated'));
        });

        static::created(function($pesquisa){
            event(new TccPropostaEvent($pesquisa,'created'));
        });

        static::deleting(function($pesquisa){
            event(new TccPropostaEvent($pesquisa,'deleted'));
        });
    }
}