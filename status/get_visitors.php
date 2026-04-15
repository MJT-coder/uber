<?php
    $file = 'visitors_status.json';
    $visitors = [];

    if (file_exists($file)) {
        $visitors = json_decode(file_get_contents($file), true) ?: [];
    }

    header('Content-Type: application/json');
    echo json_encode($visitors);
?>