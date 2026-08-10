<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'Templates count: ' . App\Models\Template::count() . PHP_EOL;
echo 'Categories count: ' . App\Models\Category::count() . PHP_EOL;
$t = App\Models\Template::first();
echo 'First template id_category: ' . $t->id_category . PHP_EOL;
echo 'First template category name: ' . ($t->category->name ?? 'null') . PHP_EOL;
