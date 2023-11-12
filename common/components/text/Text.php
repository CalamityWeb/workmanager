<?php

namespace tframe\common\components\text;

use tframe\core\Application;

class Text {
    public static function notSetText(string $class = ''): string {
        return '<span class="text-danger fst-italic ' . $class . '">(' . Application::t('general', 'not set') . ')</span>';
    }
}