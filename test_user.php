<?php

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$user = User::first();
if ($user) {
    echo 'User: '.$user->name.PHP_EOL;
    echo 'Email verified: '.($user->hasVerifiedEmail() ? 'yes' : 'no').PHP_EOL;
    echo 'Is admin: '.($user->isAdmin() ? 'yes' : 'no').PHP_EOL;
} else {
    echo 'No users found';
}
