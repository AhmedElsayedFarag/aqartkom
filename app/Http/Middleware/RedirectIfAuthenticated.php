<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                switch (true) {
                    case auth()->user()->hasRole('admin'):
                        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
                        // case auth()->user()->hasRole('company') && is_null(auth()->user()->activeSubscription()):
                        //     return redirect()->route('front.subscription.create');
                    default:
                        return redirect()->intended(RouteServiceProvider::FRONT_HOME);
                }
            }
        }

        return $next($request);
    }
}