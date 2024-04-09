<?php

namespace calamity\common\components\text;

use calamity\core\Calamity;

class Text {
    public static function notSetText (string $class = ''): string {
        return '<span class="text-danger fst-italic ' . $class . '">(' . Calamity::t('general', 'not set') . ')</span>';
    }
}