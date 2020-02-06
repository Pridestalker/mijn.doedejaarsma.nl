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
        if (!\Auth::check() || $request->user()->is_active) {
            return $next($request);
        }

        \Auth::logout();
        $message = <<<HTML
<span>
Je account is niet langer actief. Inloggen is daarom niet mogelijk.
Neem bij vragen contact op met <a href="mailto:support@doedejaarsma.nl">support@doedejaarsma.nl</a>.
</span>
HTML;
        $errors = new MessageBag();
        $errors->add(
            'deactivated',
            $message
        );

        return redirect()
            ->to('/login')
            ->withErrors($errors);
    }
}
