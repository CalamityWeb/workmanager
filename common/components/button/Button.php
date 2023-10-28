<?php

namespace tframe\common\components\button;

class Button {
    public static function generateButton(string $type, string $text, string $class, string $icon = null, array $options = []): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $icon = $icon == null ? '' : '<span class="fa-solid ' . $icon . ' me-1"></span> ';
        return '<button type="' . $type . '" class="btn ' . $class . '" ' . implode(" ", $attributes) . '>' . $icon . $text . '</button>';
    }
}