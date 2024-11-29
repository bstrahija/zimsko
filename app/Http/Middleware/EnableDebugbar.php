<?php

namespace App\Http\Middleware;

use Barryvdh\Debugbar\Facades\Debugbar;
use Closure;
use Illuminate\Support\Facades\Auth;

class EnableDebugbar
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
        if (Auth::check()) {
            Debugbar::enable();
        } else {
            Debugbar::disable();
        }

        return $next($request);
    }
}
