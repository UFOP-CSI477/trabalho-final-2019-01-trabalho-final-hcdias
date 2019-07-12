<?php

namespace PesquisaProjeto\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'PesquisaProjeto\Events\Event' => [
            'PesquisaProjeto\Listeners\EventListener',
        ],
        'PesquisaProjeto\Events\PesquisaEvent'=>[
            'PesquisaProjeto\Listeners\PesquisaListener'
        ],
        'PesquisaProjeto\Events\TccEvent'=>[
            'PesquisaProjeto\Listeners\TccListener'
        ],
        'PesquisaProjeto\Events\MestradoEvent'=>[
            'PesquisaProjeto\Listeners\MestradoListener'
        ],
        'PesquisaProjeto\Events\ExtensaoEvent'=>[
            'PesquisaProjeto\Listeners\ExtensaoListener'
        ],
        'PesquisaProjeto\Events\TccPropostaEvent'=>[
            'PesquisaProjeto\Listeners\TccPropostaListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
