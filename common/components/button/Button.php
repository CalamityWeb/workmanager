<?php

namespace calamity\common\components\button;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\exception\InvalidConfigException;

class Button {
    public static function generateButton (string $type, string $text, string $class, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        return '<button type="' . $type . '" class="btn ' . $class . '" ' . implode(" ", $attributes) . '>' . $icon . $text . '</button>';
    }

    public static function generateCaptchaButton(string $id, string $text, string $class, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }

        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        $attr = implode(" ", $attributes);

        if (!isset(Calamity::$config['google']['captcha_site_key']) and !isset(Calamity::$config['google']['captcha_secret_key'])) {
            throw new InvalidConfigException(Calamity::t('general', 'Google captcha doesn\'t configured properly!'));
        }
        $site_key = Calamity::$config['google']['captcha_site_key'];

        Calamity::$app->view->registerJS('function onSubmit(token) {document.getElementById("' . $id . '").submit();}');

        return <<<HTML
            <button class="btn g-recaptcha $class" data-sitekey="$site_key" data-callback='onSubmit' data-action='submit' $attr>
                $icon $text
            </button>
        HTML;
    }

    public static function generateClickButton (string $url, string $class, string $text, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        return '<a href="' . $url . '" class="btn ' . $class . '" ' . implode(" ", $attributes) . '>' . $icon . $text . '</a>';
    }
}