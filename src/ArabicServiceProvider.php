<?php

namespace Adnane\Arabic;
use Illuminate\Support\ServiceProvider;

class ArabicServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->make('Adnane\Arabic\Arabic');
    }
}
