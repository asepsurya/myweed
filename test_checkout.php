<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
if (! $user) {
    echo "No users found\n";
    exit(1);
}

$request = Request::create('/subscription-plans/1', 'GET');
$request->setUserResolver(function () use ($user) {
    return $user;
});

try {
    $response = $app->handle($request);
    echo 'Status: '.$response->getStatusCode()."\n";
    echo substr($response->getContent(), 0, 5000);
} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
