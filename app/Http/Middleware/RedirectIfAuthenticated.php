<?php

namespace App\Http\Middleware;

use App\Providers\HeleUserProvider;
use App\Providers\RouteServiceProvider;
use Closure;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has(HeleUserProvider::TOKEN)) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
