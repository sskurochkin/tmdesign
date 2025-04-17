<?php
$url = 'https://abby.rbsuat.com/payment/rest/register.do';


$amount     = empty($_GET['amount']) ? 1 : max(1,(int)$_GET['amount']);
$transactionID   = (int) str_replace('.', '',number_format(microtime(true), 4, '.', ''));

$postData = [
    'amount' => $amount,
    'currency' => 933,
    'userName' => 'tmdesign.by_TW6LUTCUXSOFFSAGSNTK-api',
    'password' => ')XW7n6oq',
    'returnUrl' => 'https://t.me/',
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
} else {
    throw new Exception("API request failed. HTTP code: {$httpCode}, Response: {$response}");
}
?>