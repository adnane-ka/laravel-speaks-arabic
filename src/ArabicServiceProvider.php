<?php

namespace Adnane\Arabic;
use Illuminate\Support\ServiceProvider;

use Adnane\Arabic\Arabic;
use Blade;

class ArabicServiceProvider extends ServiceProvider
{
    /**
	 * Bootstrap any application services.
	 *
	 * @return string
	 */
	public function boot()
	{
        /* registering blade directives */
        Blade::directive('toWords', function ($expression) 
        {
            return Arabic::toWords($expression);
        });

        Blade::directive('toOrdinal', function ($expression) 
        {
            return Arabic::toOrdinal($expression);
        });

        Blade::directive('toIndianNums', function ($expression) 
        {
            return Arabic::toIndianNums($expression);
        });

        Blade::directive('toHijri', function ($expression) 
        {
            return Arabic::toHijri('f',$expression);
        });

        Blade::directive('toRelative', function ($expression) 
        {
            return Arabic::toRelative($expression);
        });

        Blade::directive('removeHarakat', function ($expression) 
        {
            return Arabic::removeHarakat($expression);
        });
	}

    /**
	 * Register any application services.
	 *
	 * @return void
	 */
    public function register()
    {
        $this->app->make('Adnane\Arabic\Arabic');
    }
}
