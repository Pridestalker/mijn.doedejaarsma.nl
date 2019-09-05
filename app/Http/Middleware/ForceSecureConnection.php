<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use App;

class ForceSecureConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && App::environment() === 'production') {
            return redirect()->secure($request->getRequestUri());
        }
    
        return $next($request);
    }
}
