<?php

use App\Models\Category;
use App\Models\Template;
use Illuminate\Contracts\Console\Kernel;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

echo 'Templates count: '.Template::count().PHP_EOL;
echo 'Categories count: '.Category::count().PHP_EOL;
$t = Template::first();
echo 'First template id_category: '.$t->id_category.PHP_EOL;
echo 'First template category name: '.($t->category->name ?? 'null').PHP_EOL;
