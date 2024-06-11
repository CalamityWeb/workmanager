<?php

namespace calamity\common\models\core\exception;

use calamity\common\models\core\Calamity;
use Exception;

class Error {
    public static function sendErrorEmail(Exception $e) {
        if ($e->getCode() === 404 || $e->getCode() === 403 || $e->getCode() === 401) {
            return;
        }

        $mailer = Calamity::$app->mailer;
        $recepients = ['tokrist15@gmail.com'];

        if (empty($recepients)) {
            $mailer->setAddress([$mailer->SYSTEM_ADDRESS, $mailer->SUPPORT_ADDRESS]);
        } else {
            $mailer->setAddress($recepients);
        }

        $mailer->setSubject(Calamity::$GLOBALS["APP_NAME"] . " ERROR - " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://") . $_SERVER['HTTP_HOST']);

        $output = $e;
        $output .= "<br><pre>";

        $output .= '$SERVER = [<br>';
        unset($_SERVER['DATABASE_PASSWORD']);
        unset($_SERVER['EMAIL_PASSWORD']);
        unset($_SERVER['GOOGLE_CAPTCHA_SECRET_KEY']);
        foreach ($_SERVER as $key => $value) {
            $output .= "\t$key => $value,<br>";
        }
        $output .= ']<br><br>';

        $output .= '$GET = [<br>';
        foreach ($_GET as $key => $value) {
            $output .= "\t$key => $value,<br>";
        }
        $output .= ']<br><br>';

        $output .= '$POST = [<br>';
        foreach ($_POST as $key => $value) {
            $output .= "\t$key => $value,<br>";
        }
        $output .= ']<br><br>';

        $output .= '</pre>';

        $mailer->setBody($output);

        $mailer->send();
    }
}