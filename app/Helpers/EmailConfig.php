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
        $mail->Host = 'mail.venturabnb.pe';
        $mail->SMTPAuth = true;
        $mail->Username = 'info@venturabnb.pe';
        $mail->Password = 'ventura2025#';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->Subject = '' . $name . ', '.$mensaje. '';
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('info@venturabnb.pe', 'Ventura');
        return $mail;
    }
}
