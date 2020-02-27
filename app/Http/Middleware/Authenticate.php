<?php

namespace App\Http\Middleware;

use App\Providers\HeleUserProvider;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!$request->session()->has(HeleUserProvider::TOKEN)) {
            return redirect($this->redirectTo($request));
        }

        return $next($request);
    }
}
