<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsDemoMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (demo_mode()) {
            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')) {
                if($request->expectsJson()){
                    $result = array('success' => false, 'message' => ___('These features are disabled on the demo site.'));
                    return response()->json($result, 200);
                } else {
                    quick_alert_error(___('These features are disabled on the demo site.'));
                    return back();
                }

            }
        }
        return $next($request);
    }
}
