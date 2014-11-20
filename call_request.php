<?php
    // 1. infosmska.ru settings
    $login = '';
    $password = '';
    $phone = '';
    $sender = 'SMS';
    $translite_sms = true;
    $send_sms = true;
    $sms_text_callRequest = 'Call request';
    $sms_text_fastOrder = 'Fast order';
    $sms_text_formMessage = 'Contact form';


    // 3. General settings
    $sender_name = 'Mysuper shop';

    // 2. email settings
    require_once('PHPMailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->SMTPKeepAlive = true;
    $mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'lol@yandex.ru';                 // SMTP username
    $mail->Password = '';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';
    $mail->From = 'lol@yandex.ru';
    $mail->FromName = $sender_name;
    $mail->addAddress('lol@yandex.ru', 'Joe User');     // Add a recipient
    $mail->isHTML(true);
    $email_text_callRequest = 'Обратный звонок';
    $email_text_fastOrder = 'Быстрый заказ';
    $email_text_formMessage = 'Форма контакта';



    //get form fields
    $c_product = htmlspecialchars(addslashes(trim($_POST['product'])));
    $c_model = htmlspecialchars(addslashes(trim($_POST['model'])));
    $c_price = htmlspecialchars(addslashes(trim($_POST['price'])));
    $c_name = htmlspecialchars(addslashes(trim($_POST['name'])));
    $c_email = htmlspecialchars(addslashes(trim($_POST['email'])));
    $c_phone = htmlspecialchars(addslashes(trim($_POST['phone'])));
    $c_message = htmlspecialchars(addslashes(trim($_POST['message'])));
    $date = date('d.m.Y H:i');


    if (isset($c_product) && $c_product!=="" && isset($c_phone) && $c_phone!=="") {
      //быстрый заказ
      $mail->Subject = $email_text_fastOrder . ' - ' . $date;
      $mail->Body =
        $email_text_fastOrder . ' - ' . $date . "\n\n" .
        "Товар: " . $c_product . "\n" .
        "Модель: " . $c_model . "\n" .
        "Цена: " . $c_price . "\n" .
        "Имя: " . $c_name . "\n" .
        "Телефон: " . $c_phone . "\n" .
        "Комментарий: " . $c_message;
      if ($sender == 'SMS') {$sms_text = $sender_name . ' ';}
      $sms_text .= $sms_text_fastOrder . ': ' . $c_phone . ' ' . $c_product;
      if (isset($c_model) && $c_model!=="") {
        $sms_text .= ' model: ' . $c_model;
      }

      if (isset($c_message) && $c_message!=="") {
        $sms_text .= ' msg: ' . $c_message;
      }
      $mail->send();
      if ($send_sms) {sendSMS($login, $password, $phone, $sms_text, $sender); }
      echo "Fast order sended";
    } elseif (isset($c_email) && $c_email!=="" && isset($c_message) && $c_message!=="") {
      //контактная форма
      $mail->Subject = $email_text_formMessage . ' - ' . $date;
      $mail->Body =
        $email_text_formMessage . ' - ' . $date . "\n\n" .
        "Имя: " . $c_name . "\n" .
        "Электропочта: " . $c_email . "\n" .
        "Телефон: " . $c_phone . "\n" .
        "Сообщение: " . $c_message;
      if ($sender == 'SMS') {$sms_text = $sender_name . ' ';}
      $sms_text .= $sms_text_formMessage . ': ' . $c_email;
      if (isset($c_phone) && $c_phone!=="") {
        $sms_text .= ' ' . $c_phone;
      }
      $mail->send();
      if ($send_sms) {sendSMS($login, $password, $phone, $sms_text, $sender); }
      echo "Contact form sended";
    } elseif (isset($c_phone) && $c_phone!=="") {
        //обратный звонок
        $mail->Subject = $email_text_callRequest . ' - ' . $date;
        $mail->Body =
          $email_text_callRequest . ' - ' . $date . "\n\n" .
          "Имя: " . $c_name . "\n" .
          "Электропочта: " . $c_email . "\n" .
          "Телефон: " . $c_phone . "\n" .
          "Сообщение: " . $c_message;
        if ($sender == 'SMS') {$sms_text = $sender_name . ' ';}
        $sms_text .= $sms_text_callRequest . ': ' . $c_phone;
        if (isset($c_name) && $c_name!=="") {
          $sms_text .= ' ' . $c_name;
        }
        $mail->send();
        if ($send_sms) {sendSMS($login, $password, $phone, $sms_text, $sender); }
        echo "Call request sended";
      } else {echo "Nothing to send";}




    function translit ($str) // translit by programmerz.ru
    {
        $tr = array("А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E","Ё"=>"E","Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"4","Ш"=>"SH","Щ"=>"SC","Ъ"=>"","Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"U","Я"=>"YA","а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"4","ш"=>"sh","щ"=>"sch","ъ"=>"y","ы"=>"y","ь"=>"","э"=>"e","ю"=>"u","я"=>"ya");
        return strtr($str,$tr);
    }

    function sendSMS($login, $password, $phone, $text, $sender) {
    if ($translite_sms) {$text = translit($text);}
    $host = "api.infosmska.ru";
    $fp = fsockopen($host, 80);
    fwrite($fp, "GET /interfaces/SendMessages.ashx" .
        "?login=" . rawurlencode($login) .
        "&pwd=" . rawurlencode($password) .
        "&phones=" . rawurlencode($phone) .
        "&message=" . rawurlencode($text) .
        "&sender=" . rawurlencode($sender) .
        "  HTTP/1.1\r\nHost: $host\r\nConnection: Close\r\n\r\n");
    fwrite($fp, "Host: " . $host . "\r\n");
    fwrite($fp, "\n");
    while(!feof($fp)) {
        $response .= fread($fp, 1);
    }
    fclose($fp);

    list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
    list($other, $ids_str) = explode(":", $responseBody, 2);
    list($sms_id, $other) = explode(";", $ids_str, 2);

    return $sms_id;
    }
