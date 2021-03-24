<?php

namespace Adnane\Arabic;
use Illuminate\Support\ServiceProvider;

class ArabicServiceProvider extends ServiceProvider
{
    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        /* register classess */
        $this->app->make('Adnane\Arabic\Ar\Tafkit');
        $this->app->make('Adnane\Arabic\Ar\Strings');
        $this->app->make('Adnane\Arabic\Ar\Tawkit');

        $this->app->make('Adnane\Arabic\Arabic');
    }
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
       //
    }
}
