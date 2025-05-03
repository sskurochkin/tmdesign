<?php
$userMail = htmlspecialchars($_GET['userMail'] ?? '');
$tarif = htmlspecialchars($_GET['tarif'] ?? '');

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
//require 'class.HTTP.php';

$mail = new PHPMailer\PHPMailer\PHPMailer();

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
//    $mail->addAddress('idsemen1992@ya.ru', 'Имя получателя');
    $mail->addAddress($userMail, 'Имя получателя');

    // Тема и содержимое
    $mail->isHTML(true);
    $mail->Subject = 'Доступ к курсу';
    $mail->Body = '
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
             
            <a class="btn" href="https://t.me/+23Ic4ID6G_FhOGJi">ПЕРЕЙТИ К КАНАЛУ</a>
           
            <br>
            В канале вы найдете:
            <ul>
            <li>Ссылки для доступа к видео-урокам курса.</li>
            <li>Дополнительные материалы и конспекты к каждому уроку.</li>
            </ul>
             
            Если не получается перейти по кнопке, скопируйте ссылку и вставьте в строку вашего браузера:
            <a href="https://t.me/+23Ic4ID6G_FhOGJi">https://t.me/+23Ic4ID6G_FhOGJi</a>
            <br>
            Для своевременного получения информации рекомендую закрепить канал в вашем телеграме.
            <p>Если у вас возникнут вопросы или трудности с подключением, свяжитесь со мной.</p>
           
            Желаю удачи! 
            <br>
            <br>
            С уважением,<br>
            Татьяна Киреева
            </div>
            ';
    $mail->AltBody = 'Текстовая версия письма';

    $mail->send();
    echo 'Письмо отправлено!' . $userMail;
} catch (Exception $e) {
    echo "Ошибка: {$mail->ErrorInfo}";
}


header("Location: https://t.me/+23Ic4ID6G_FhOGJi");
exit();


?>

