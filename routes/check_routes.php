<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Route;

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();
$routes = Route::getRoutes();
foreach ($routes as $route) {
    if (strpos($route->uri(), 'template-creator') !== false) {
        echo $route->methods()[0].' '.$route->uri().' -> '.$route->getName().PHP_EOL;
    }
}
