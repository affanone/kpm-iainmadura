<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLoginMiddleware
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
        if ($request->session()->exists("token_api")) {
            switch (session("level")) {
                /*
                0 => lp2m,
                1 => dpl,
                2 => mhs
                 */
                case 0:
                    return redirect()->to("super");
                case 1:
                    return redirect()->to("dpl");
                case 2:
                    return redirect()->to("mhs");
                case 3:
                    return redirect()->to("fakultas");
            }
        }
        return $next($request);
    }
}
