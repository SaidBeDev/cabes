<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Activation;

class verifyEmail
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
        if (!empty(Auth::user())) {
            $act = Activation::exists(Auth::user());

            if (Activation::completed(Auth::user())) {
                return $next($request);
            } elseif ($act) {
                $response = [
                    'success' => false,
                    'message' => trans('notifications.not_verified')
                ];

                return redirect()->route('auth.welcome')->with($response);
            }
        } else {
            return redirect()->back();
        }


    }
}
