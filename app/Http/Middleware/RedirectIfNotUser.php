<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class RedirectIfNotUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next){

        $cookie_token=Cookie::get('token');
        if (Auth::check())
            return $next($request);
        elseif (isset($cookie_token)){
            $user=User::getByRemember($cookie_token);
            if ($user){
                auth()->login($user);
                return $next($request);
            }
            else{
                if ( $request->expectsJson())
                    return response()->json(['error'=>"not authenticated"],422);
                return  redirect('/');
            }

        }
        return redirect('/');

    }

}
