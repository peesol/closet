<?php

namespace Closet\Providers;

use URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Paginator::defaultView('pagination::default');

      Paginator::defaultSimpleView('pagination::simple-default');

      Schema::defaultStringLength(191);

      if($this->app->environment('production')) {
        URL::forceScheme('https');
      }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
