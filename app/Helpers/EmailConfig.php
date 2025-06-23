<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use App\Models\General;
class EmailConfig
{
    static  function config($name, $mensaje): PHPMailer
    {
        $general = General::first();
        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hola@mundoweb.pe';
        $mail->Password = 'ejzouhgnohvvbdwa';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;
        $mail->Subject = '' . $name . ', '.$mensaje. '';
        $mail->CharSet = 'UTF-8';
        $mail->setFrom('info@venturabnb.pe', 'Ventura');
        return $mail;
    }
}
