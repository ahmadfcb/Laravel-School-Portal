<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.main', function($view){
            $view->with('_user', auth()->user());
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}