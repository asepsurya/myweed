<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Midtrans\Config;
use Symfony\Component\HttpFoundation\Response;

class MidtransConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Optional: validasi minimal payload
        // if (!$request->has('order_id')) {
        //     return response()->json([
        //         'message' => 'Invalid Midtrans payload'
        //     ], 400);
        // }

        return $next($request);
    }
}
