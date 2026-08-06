<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\MidtransConfig;
use App\Http\Middleware\RedirectByRole;
use App\Http\Middleware\CheckSubscription;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (UnauthorizedException $e, $request) {
            return match (auth()->user()->getRoleNames()->first()) {
                'admin' => redirect()->route('dashboard'),
                default => redirect()->route('dashboard.user'),
            };
        });

    })->withMiddleware(function (Middleware $middleware): void {
          $middleware->prependToGroup('guest', RedirectByRole::class);
          $middleware->alias([
                'role' => RoleMiddleware::class,
                'permission' => PermissionMiddleware::class,
                'role_or_permission' => RoleOrPermissionMiddleware::class,
                'subscription' => CheckSubscription::class,
                'midtrans' => MidtransConfig::class,
            ]);
            $middleware->append(MidtransConfig::class);
            $middleware->validateCsrfTokens(except: [
                'api/midtrans/callback',
            ]);
    })->create();
