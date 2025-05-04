<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = 'https://abby.rbsuat.com/payment/rest/register.do';
    $BOT_TOKEN = '7659117318:AAEK07veMrkuY4o7ne920gWbQavb3K0DmWE';
    $CHAT_ID = '623958700';
//    $CHAT_ID = '529572469';

    $transactionID   = (int) str_replace('.', '',number_format(microtime(true), 4, '.', ''));

//
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $sum = $amount/100;
    $text = "Новая заявка:\nИмя: $name\nТелефон: $phone\nEmail: $email\nСумма: $sum BYN\nЗаказ: $transactionID";

    $section = 1;
    if($amount == '155000'){
        $section = 2;
    }
    if($amount == '465000'){
        $section = 3;
    }

    $postData = [
        'amount' => $amount,
        'currency' => 933,
        'userName' => 'tmdesign.by_TW6LUTCUXSOFFSAGSNTK-api',
        'password' => ')XW7n6oq',
        'returnUrl' => 'https://tmdesign.by/send.php?userMail='. $email . '&stage=' . $section . '&orderNumber=' . $transactionID,
//    'description' => 'my_first_order',
        'language' => 'ru',
        'orderNumber' => $transactionID
    ];


    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($postData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true // Рекомендуется оставить true для продакшена
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

// Обработка ответа
    if ($httpCode >= 200 && $httpCode < 300) {
//    $decodedResponse = json_decode($response, true);
        print_r($response); // или другая обработка
        $urlTg = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage?chat_id=$CHAT_ID&text=" . urlencode($text);
        file_get_contents($urlTg);
    } else {
        throw new Exception("API request failed. HTTP code: {$httpCode}, Response: {$response}");
    }



}

?>