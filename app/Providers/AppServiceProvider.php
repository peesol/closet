<?php

namespace Closet\Providers;

use URL;
use Horizon;
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

      Horizon::auth(function ($request) {
        return $request->user()->id === 1;
      });
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
