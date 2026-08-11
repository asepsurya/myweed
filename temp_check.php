<?php

$pdo = new PDO('sqlite:D:/Project/myweed/database/database.sqlite');
$stmt = $pdo->query('SELECT id, name, slug FROM templates');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
echo "\n--- Table structure ---\n";
$stmt = $pdo->query('PRAGMA table_info(templates)');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    print_r($row);
}
