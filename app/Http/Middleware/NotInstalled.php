<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class NotInstalled
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (!env('APP_INSTALLED')) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
