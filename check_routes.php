<?php

use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
$routes = collect(Route::getRoutes()->getRoutes())->filter(function ($r) {
    return str_contains($r->uri(), 'categories');
});
foreach ($routes as $r) {
    echo implode('|', $r->methods()).' '.$r->uri().PHP_EOL;
}
