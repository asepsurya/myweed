<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return $next($request);
        }
       if (!auth()->check() || !auth()->user()->isSubscribed()) {
            return redirect()->route('subscribe.page')
                ->with('warning', 'Silakan berlangganan terlebih dahulu.');
        }

        return $next($request);
    }
}
