<?php

namespace tframe\common\components\form;

use tframe\common\components\button\Button;
use tframe\core\Model;

class Form {
    private array $disabledFields = [];

    public static function begin(string $method, array $options = [], string $action = ''): Form {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));

        echo "<form action=\"$action\" method=\"$method\" " . implode(" ", $attributes) . ">";
        return new Form();
    }

    public static function end(): void {
        echo '</form>';
    }

    public function submitButton(string $text, string $class, string $icon = null, array $options = []): string {
        return '<div class="mb-3">' . Button::generateButton('submit', $text, $class, $icon, $options) . '</div>';
    }

    public function disabledFields(array $fields): void {
        foreach ($fields as $field) {
            $this->disabledFields[] = $field;
        }
    }

    public function field(Model $model, $attribute, $options = []): Field {
        $disabled = in_array($attribute, $this->disabledFields);
        return new Field($model, $attribute, $options, $disabled);
    }

    public function fieldWithIcon(Model $model, $attribute, $icon, $options = []): FieldWithIcon {
        $disabled = in_array($attribute, $this->disabledFields);
        return new FieldWithIcon($model, $attribute, $icon, $options, $disabled);
    }
}