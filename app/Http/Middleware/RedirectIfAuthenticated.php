<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class RedirectIfAuthenticated
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
        $cookie_token=Cookie::get('token');
        $user=auth()->guard('api')->user();;
        if (Auth::guard($guard)->check() || (isset($cookie_token) and $user)) {
            return redirect('/dashboard');
        }
        return $next($request);


    }
}
