<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;

class EmailConfig
{
    static  function config($name, $mensaje): PHPMailer
    {
        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'mail.boostperu.com.pe';
        $mail->SMTPAuth = true;
        $mail->Username = '#';
        $mail->Password = '#';
        // $mail->Username = 'boostperuatencion@gmail.com';
        // $mail->Password = 'hlabkcttomghufms';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->Subject = '' . $name . ', '.$mensaje. '';
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('atencionalcliente@boostperu.com.pe', 'BoostPeru');
        return $mail;
    }
}
