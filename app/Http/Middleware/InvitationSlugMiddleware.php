<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InvitationSlugMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          $slug = $request->route('slug');

        // 🔒 Reserved routes (TIDAK BOLEH jadi slug)
        $reserved = [
            'login', 'register', 'logout',
            'dashboard', 'admin',
            'api', 'storage',
            'css', 'js', 'images',
        ];

        if (in_array($slug, $reserved)) {
            abort(404);
        }

        // 🔍 Cek slug ada di database
        if (!Invitation::where('slug', $slug)->exists()) {
            abort(404);
        }

        return $next($request);
    }
}
