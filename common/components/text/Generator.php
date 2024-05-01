<?php

namespace calamity\common\components\text;

class Generator {
    public static function randomString ($model = null, string $key = null, int $length = 16, bool $lowercase = true, bool $uppercase = true, bool $numbers = true, bool $special = false): string {
        $value = '';
        $characters = '';

        if ($lowercase) {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($uppercase) {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($numbers) {
            $characters .= '0123456789';
        }
        if ($special) {
            $characters .= '!@#$%*()-_';
        }
        $charactersLength = strlen($characters);

        if ($key != null and $model != null) {
            do {
                for ($i = 0; $i < $length; $i++) {
                    $value .= $characters[random_int(0, $charactersLength - 1)];
                }

                $found = $model::findOne([$key => $value]);
            } while ($found);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $value .= $characters[random_int(0, $charactersLength - 1)];
            }
        }

        return $value;
    }
}