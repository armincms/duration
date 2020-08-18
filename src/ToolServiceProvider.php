<?php

namespace Armincms\Duration;
 
use Illuminate\Support\ServiceProvider; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations'); 
    } 
}
