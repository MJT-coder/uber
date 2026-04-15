<?php
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) exit;

    $status = $data['status'] ?? '';
    $page   = $data['page']   ?? '';

    if ($status) {
        $ip = $_SERVER['REMOTE_ADDR'] == "::1" ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'];

        $file = './visitors_status.json';
        $visitors = [];

        if (file_exists($file)) {
            $visitors = json_decode(file_get_contents($file), true) ?: [];
        }

        $visitors[$ip] = [
            'status' => $status,
            'last_update' => time(),
            'current_page' => $page,
        ];

        file_put_contents($file, json_encode($visitors)); 
    }
?>
