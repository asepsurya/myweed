<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$template = \App\Models\Template::where('slug', 'love-theme')->first(['id','name','slug','sections','is_active']);
if ($template) {
    echo "FOUND:\n";
    print_r($template->toArray());
} else {
    echo "NOT FOUND\n";
}
