<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
    public function handle($request, Closure $next,  ...$guards)
    {

        if (in_array('api', $guards)) {
            if (!Auth::guard('api')->user()) {
                return response()->json(['status' => 'unauthorized', 'message' => 'Unauthorized.'], 401);
            }
        } else if (!Auth::check()) {
            return redirect('/login');
        }
        return $next($request);
    }
}
