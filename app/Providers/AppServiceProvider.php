<?php

namespace App\Providers;

use App\Models\Payment;
use App\View\TemplateViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Midtrans\Config as MidtransConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        MidtransConfig::$serverKey = config('midtrans.server_key');
        MidtransConfig::$isProduction = config('midtrans.is_production');
        MidtransConfig::$isSanitized = true;
        MidtransConfig::$is3ds = true;

        Paginator::useBootstrap();

        $finder = new TemplateViewFinder(
            new Filesystem(),
            $this->app['config']['view.paths'],
            ['blade.php', 'php', 'css', 'html']
        );

        $this->app->singleton('view.finder', function () use ($finder) {
            return $finder;
        });

        if ($this->app->resolved('view')) {
            $this->app['view']->setFinder($finder);
        }

        View::composer('layouts.partial.user_sidebar', function ($view) {
            if (auth()->check()) {
                $pendingCount = Payment::where('user_id', auth()->id())
                    ->whereIn('status', ['pending', 'failed'])
                    ->count();
                $view->with('pendingPaymentCount', $pendingCount);
            } else {
                $view->with('pendingPaymentCount', 0);
            }
        });
    }
}
