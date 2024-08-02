<?php

namespace calamity\common\components\form;

use calamity\common\components\button\Button;
use calamity\common\models\core\Calamity;
use calamity\common\models\core\Model;

class Form {
    private array $disabledFields = [];
    private bool $csrf;

    public const string CSRF = 'csrf';

    public function __construct($csrf) {
        $this->csrf = $csrf;

        $this->csrfField();
    }

    public static function begin (string $method, array $options = [], string $action = ''): Form {
        $attributes = [];
        $csrf = true;
        foreach ($options as $key => $value) {
            if($key == self::CSRF) {
                $csrf = $value;
            } else {
                $attributes[] = "$key=\"$value\"";
            }
        }

        echo "<form action=\"$action\" method=\"$method\" " . implode(" ", $attributes) . ">";
        return new Form($csrf);
    }

    public static function end (): void {
        echo '</form>';
    }

    public function submitButton (string $text, string $class, string $icon = null, array $options = []): string {
        return '<div class="mb-3">' . Button::generateButton('submit', $text, $class, $icon, $options) . '</div>';
    }

    public function captchaSubmitButton(string $id, string $text, string $class, string $icon = null, array $options = []): string {
        return '<div class="mb-3">' . Button::generateCaptchaButton($id, $text, $class, $icon, $options) . '</div>';
    }

    public function disabledFields (array|string $fields): void {
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $this->disabledFields[] = $field;
            }
        } else {
            $this->disabledFields[] = $fields;
        }
    }

    public function field (Model $model, $attribute, $options = []): Field {
        $disabled = in_array($attribute, $this->disabledFields);
        return new Field($model, $attribute, $options, $disabled);
    }

    public function fieldWithIcon (Model $model, $attribute, $icon, $options = []): FieldWithIcon {
        $disabled = in_array($attribute, $this->disabledFields);
        return new FieldWithIcon($model, $attribute, $icon, $options, $disabled);
    }

    public function selectField (Model $model, $attribute, array $choices, bool $canBeNull = true, $options = []): SelectField {
        $disabled = in_array($attribute, $this->disabledFields);
        return new SelectField($model, $attribute, $options, $choices, $canBeNull, $disabled);
    }

    public function switchField (Model $model, $attribute, $options = []): SwitchField {
        $disabled = in_array($attribute, $this->disabledFields);
        return new SwitchField($model, $attribute, $options, $disabled);
    }

    public function textareaField (Model $model, $attribute, $options = []): TextareaField {
        $disabled = in_array($attribute, $this->disabledFields);
        return new TextareaField($model, $attribute, $options, $disabled);
    }

    public function icheckField (Model $model, $attribute, $options = []): IcheckField {
        $disabled = in_array($attribute, $this->disabledFields);
        return new IcheckField($model, $attribute, $options, $disabled);
    }

    public function csrfField(): void {
        if ($this->csrf) {
            echo '<input type="hidden" name="csrf" value="' . base64_encode(Calamity::$app->csrf) . '" >';
        }
    }
}