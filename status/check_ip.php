<?php

  include "../Assets/php/config/config.php";

header('Content-Type: application/json');



$ip = get_client_ip();
$file = '../data/blocker.json';

$blocked = false;

if (file_exists($file)) {
    $blockedIps = json_decode(file_get_contents($file), true);

    if (is_array($blockedIps) && in_array($ip, $blockedIps, true)) {
        $blocked = true;
    }
}

echo json_encode([
    'blocked' => $blocked
]);
exit;
