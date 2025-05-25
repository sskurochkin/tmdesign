<?php

$url = 'https://ecom.alfabank.by/payment/rest/getOrderStatusExtended.do';
$userMail = htmlspecialchars($_GET['userMail'] ?? '');
$stage = htmlspecialchars($_GET['stage'] ?? '');
$orderID = htmlspecialchars($_GET['orderId'] ?? '');
$orderNumber = htmlspecialchars($_GET['orderNumber'] ?? '');

$tpl = '';
$link = "https://t.me/+23Ic4ID6G_FhOGJi";
if ($stage == '2' || $stage == '3') {
    $tpl = "<h4 style='text-decoration: underline'>У меня для вас сюрприз!</h4>
            <p>2 дополнительных гайда к урокам! Бонусы можно забрать в Telegram-боте по ссылке ниже:</p>         
            <p> Перейти в чат бот <a href='https://t.me/tmdesignby_bot'>@tmdesignby_bot</a></p>
            <br>
            ";
}


$postData = [
    'userName' => 'TMDESIGN-api',
    'password' => '!Tmdesign_api2025',
    'orderNumber' => $orderNumber
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

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('Invalid JSON: ' . json_last_error_msg());
    }

    $status = $data['orderStatus'] ?? null;

    if ($status === 2) {
        require 'phpmailer/PHPMailer.php';
        require 'phpmailer/SMTP.php';
        require 'phpmailer/Exception.php';
        //require 'class.HTTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->CharSet = 'UTF-8'; // Установка кодировки
        $mail->Encoding = 'base64'; // Дополнительная защита

        try {
            // Настройки SMTP
            $mail->isSMTP();
            $mail->Host = 'mailbe03.hoster.by'; // SMTP-сервер (например, Gmail)
            $mail->SMTPAuth = true;
            $mail->Username = 'info@tmdesign.by'; // Ваш email
            $mail->Password = 'Tmdesign2025!';  // Пароль (или app-пароль для Gmail)
            $mail->SMTPSecure = 'ssl'; // SSL/TLS
            $mail->Port = 465; // Порт для SSL

            // От кого и кому
            $mail->setFrom('info@tmdesign.by', 'Онлайн-курсы Татьяны Киреевой');
            $mail->addAddress($userMail, 'Имя получателя');

            // Тема и содержимое
            $mail->isHTML(true);
            $mail->Subject = 'Доступ к курсу';
            $mail->Body = <<<HTML
            <style>
                .wrap{
                max-width: 800px;
                margin: 0 auto;
                }
                .top{
                    aspect-ratio: 2.1;
                    object-fit: cover;
                }
                .btn{
                   display: block;
                   margin: 20px auto 0;
                   line-height: 48px;
                    text-align: center;
                    width: 220px;
                    height: 48px;
                    font-weight: 500;
                    font-size: 18px;
                    border-radius: 8px;
                    background-color: #f09a9a;
                    color: #ffffff;
                    text-decoration: none;

                }
            </style>
            <div class="wrap">
            <img class="top" src="https://tmdesign.by/assets/images/mail.jpg" alt="img">
            <h3>Здравствуйте!</h3>
            <p>Поздравляю с покупкой моего онлайн-курса <i>«Макетирование одежды»</i>!</p>
            <p>Благодарю за доверие и интерес!</p>
            <b>Важная информация:</b>
            <p>Для получения всех необходимых материалов, пожалуйста, перейдите в наш Telegram-канал.</p>
            Присоединиться к каналу можно по кнопке ниже:

            <a class="btn" href="$link">ПЕРЕЙТИ К КАНАЛУ</a>
            <br>
            В канале вы найдете:
            <ul>
            <li>Ссылки для доступа к видео-урокам курса.</li>
            <li>Дополнительные материалы и конспекты к каждому уроку.</li>
            </ul>
            Если не получается перейти по кнопке, скопируйте ссылку и вставьте в строку вашего браузера:
            <a href="$link">$link</a>
            <br>
            Для своевременного получения информации рекомендую закрепить канал в вашем телеграме.

            <p>Если у вас возникнут вопросы или трудности с подключением, свяжитесь со мной в телеграм <a href='https://t.me/Tsylko'>@Tsylko</a></p>
            
            $tpl
            
            
            Желаю удачи!
            <br>
            <br>
            С уважением,<br>
            Татьяна Киреева
            </div>
HTML;
            $mail->AltBody = 'Текстовая версия письма';

            $mail->send();
            echo 'Письмо отправлено!' . $userMail;
        } catch (Exception $e) {
            echo "Ошибка: {$mail->ErrorInfo}";
        }


        header("Location:" . $link);
        exit();
    } else {
        header("Location: https://tmdesign.by");
        exit();
    }


} else {
    throw new Exception("API request failed. HTTP code: {$httpCode}, Response: {$response}");
}


?>

