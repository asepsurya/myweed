<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttpsInProduction
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('production')) {
            $forwardedProto = $request->headers->get('X-Forwarded-Proto');
            $isSecure = $request->secure() || ($forwardedProto && strtolower($forwardedProto) === 'https');

            if (! $isSecure) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
