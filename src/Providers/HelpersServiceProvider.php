<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ApiAuth;
use App\Helpers\UiHelper;

class HelpersServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap the application services.
    *
    * @return void
    */
    public function boot()
    {
        $this->bootBindings();
    }

    protected function bootBindings(){
        $this->app['App\Helpers\UiHelper'] = function ($app) {
            return $app['helpers.uihelper'];
        };
    }
    /**
    * Register the application services.
    *
    * @return void
    */
    public function register()
    {
        $this->registerUiHelper();
    }

    /**
    * Register the bindings for the main JWTAuth class.
    */

    protected function registerUiHelper()
    {
        $this->app->singleton('helpers.uihelper', function ($app) {
             return new UiHelper($app->request);
        });
    }


}
