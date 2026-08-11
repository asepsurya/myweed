<?php

use App\Models\Template;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$template = Template::where('slug', 'love-theme')->first(['id', 'name', 'slug', 'sections', 'is_active']);
if ($template) {
    echo "FOUND:\n";
    print_r($template->toArray());
} else {
    echo "NOT FOUND\n";
}
