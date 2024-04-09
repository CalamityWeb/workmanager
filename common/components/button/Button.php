<?php

namespace calamity\common\components\button;

use calamity\Calamity;
use calamity\exception\InvalidConfigException;

class Button {
    public static function generateButton (string $type, string $text, string $class, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        return '<button type="' . $type . '" class="btn ' . $class . '" ' . implode(" ", $attributes) . '>' . $icon . $text . '</button>';
    }

    public static function generateCaptchaButton(string $type, string $text, string $class, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }

        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        $attr = implode(" ", $attributes);

        if (!isset(Calamity::$config['google']['site_key']) and !isset(Calamity::$config['google']['secret_key'])) {
            throw new InvalidConfigException(Calamity::t('general', 'Google captcha doesn\'t configured properly!'));
        }
        $site_key = Calamity::$config['google']['site_key'];

        return <<<HTML
            <button type="$type" class="btn g-recaptcha $class" data-sitekey="$site_key" data-action='submit' $attr onclick="$(this).closest('form').submit();">
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