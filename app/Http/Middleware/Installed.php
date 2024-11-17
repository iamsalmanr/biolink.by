<?php

namespace App\Http\Middleware;

use Closure;

class Installed
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
        if (!env('APP_INSTALLED')) {
            return redirect()->route('install');
        }
        return $next($request);
    }
}
