<?php

namespace App\Http\Middleware;

use Closure, Session;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		if(Session::has('locale'))
        {
			app()->setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
