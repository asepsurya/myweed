<?php
require 'vendor/autoload.php';
$invitations = App\Models\Invitation::all();
foreach ($invitations as $inv) {
    echo "ID: " . $inv->id . ", Slug: " . $inv->slug . PHP_EOL;
}