<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate a request to /subscription-plans/2
$request = Illuminate\Http\Request::create('/subscription-plans/2', 'GET');

try {
    $response = $app->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    echo $response->getContent();
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
    echo "Class: " . get_class($e) . "\n";
    echo "\nTrace:\n" . $e->getTraceAsString() . "\n";
}
