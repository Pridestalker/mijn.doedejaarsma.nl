<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class UserActive
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
        if (!\Auth::check()) {
            return $next($request);
        }

        if (!$request->user()->is_active) {
            \Auth::logout();
            $errors = new MessageBag();
            $errors->add('deactivated', 'Dit account is niet langer actief');

            return redirect()
                ->to('/login')
                ->withErrors($errors);
        }

        return $next($request);
    }
}
