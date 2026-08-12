<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$blade = $app['blade.compiler'];
$content = file_get_contents(__DIR__.'/resources/views/pages/harga.blade.php');

try {
    $compiled = $blade->compileString($content);
    echo "Compiled successfully!\n";
    file_put_contents(__DIR__.'/storage/framework/views/test_harga.php', $compiled);
} catch (Exception $e) {
    echo 'Error: '.$e->getMessage()."\n";
}
