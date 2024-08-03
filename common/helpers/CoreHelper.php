<?php

namespace calamity\common\helpers;

use calamity\common\models\core\Calamity;

class CoreHelper {
    public static function checkAlias ($string): bool {
        return str_contains($string, '@');
    }

    public static function getAlias ($string): string {
        $aliases = require dirname(__DIR__) . '/config/aliases.php';

        foreach ($aliases as $alias => $value) {
            $string = str_replace($alias, $value, $string);
        }

        return $string;
    }

    public static function listAliases (): array {
        $return = [];
        foreach (require dirname(__DIR__) . '/config/aliases.php' as $alias => $dir) {
            $return[] = $alias;
        }
        return $return;
    }

    public static function validateGoogleCaptcha($captcha): bool {
        $secret = Calamity::$config['google']['captcha_secret_key'];
        $ch = curl_init("https://www.google.com/recaptcha/api/siteverify");

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "secret=" . $secret . "&response=" . $captcha);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = json_decode(curl_exec($ch), true);

        return isset($response["success"]) and $response["success"];
    }
}