<?php

namespace PesquisaProjeto\Providers;

use PesquisaProjeto\LdapiAPI\LdapiAPI;
use Illuminate\Support\ServiceProvider;

class LdapiAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('LdapiAPI',function(){
            return new LdapiAPI();
        });
    }
}
