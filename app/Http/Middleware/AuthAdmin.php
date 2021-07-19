<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {

        if (empty(Auth::user())){

            return redirect()->route('backend.loginForm');
        }
        elseif(!empty(Auth::user()) && Auth::user()->profile_type->name != "admin") {

            $response = [
                'success' => false,
                'message' => trans('notifications.unmatched_credentials')
            ];

            return redirect()->route('backend.loginForm')->with($response);
        }
        elseif (!empty(Auth::user()) && Auth::user()->profile_type->name == "admin"){

            return $next($request);
        }
        else{
           abort(403);
        }

    }
}
