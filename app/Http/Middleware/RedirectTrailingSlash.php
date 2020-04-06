<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RedirectTrailingSlash
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
        if (!preg_match('/.+\/$/', $request->getRequestUri())) {
            $newval = $request->getPathInfo() . '/';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: $newval");
        }

        return $next($request);
    }
}
