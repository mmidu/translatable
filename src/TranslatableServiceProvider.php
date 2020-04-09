<?php

namespace Mmidu\Translatable;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class TranslatableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/translatable.php' => config_path('translatable.php'),
        ], 'translatable.config');

        Session::put('language', config('translatable.default'));
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/translatable.php', 'translatable');
    }
}
