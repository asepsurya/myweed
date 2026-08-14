<?php

namespace App\Providers;

use App\View\TemplateViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class TemplateServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
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
    }
}
