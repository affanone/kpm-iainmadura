<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MhsUnregisterMiddleware
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
        if (
            !(
                $request->session()->exists("token_api") &&
                !$request->session()->get("register")
            )
        ) {
            return abort(404, "Access denied to open page !!");
        }
        return $next($request);
    }
}
