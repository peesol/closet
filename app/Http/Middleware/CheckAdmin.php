<?php

namespace Closet\Http\Middleware;

use Closure;

class CheckAdmin
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
      if ($request->user()->shop->usertype === 99) {
        return $next($request);
      } else {
        return response('WORONG PLACE ASSHOLE');
      }
    }
}
