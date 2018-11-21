<?php

namespace Closet\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->cookie('locale')) {

            $locale = $request->cookie('locale');

        } elseif (Session::has('locale')) {

            $locale = Session::get('locale', Config::get('closet.locale'));

        } else {
            $locale = 'th';
            // $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            //
            // if ($locale != 'th' && $locale != 'en') {
            //     $locale = 'en';
            // }

        }

        App::setLocale($locale);

        return $next($request);

    }
}
