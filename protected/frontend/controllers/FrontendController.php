<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Site controller
 */
class FrontendController extends Controller {

    protected function sendmail($name, $email, $subject, $body) {
        $mail = new \PHPMailer();

        $mail->isSMTP();
        $mail->SMTPDebug = 0;

        $mail->Debugoutput = 'html';

        $mail->Host = 'smtp.gmail.com';

        $mail->Port = 465;


        $mail->SMTPSecure = 'ssl';

        $mail->SMTPAuth = true;

        $mail->Username = "apksharing.net@gmail.com";

        $mail->Password = "hoang12345@12345";
        $mail->setFrom('apksharing.net@gmail.com', 'Support');
        $mail->addAddress($email, $name);

        $mail->Subject = $subject;
        $mail->msgHTML($body);
        $mail->AltBody = $body;
        var_dump($mail->send()); exit;
        if (!$mail->send()) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
