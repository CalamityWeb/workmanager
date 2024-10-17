<?php

namespace calamity\common\components\form;

use calamity\common\models\core\Model;

class Field extends BaseField {
    public const TYPE_TEXT = 'text';
    public const TYPE_NUMBER = 'number';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_FILE = 'file';
    public const TYPE_EMAIL = 'email';
    public const TYPE_TEL = 'tel';
    public const TYPE_URL = 'url';
    public const TYPE_DATE = 'date';

    public function __construct (Model $model, string $attribute, array $options, bool $disabled) {
        $this->type = self::TYPE_TEXT;
        $this->disabled = $disabled;
        parent::__construct($model, $attribute, $options);
    }

    public function renderInput (array $options): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        return '
        <input
            type="' . $this->type . '"
            class="form-control ' . ($this->model->hasError($this->attribute) ? ' is-invalid' : '') . '"
            name="' . $this->attribute . '"
            value="' . ($_POST[$this->attribute] ?? $this->model->{$this->attribute}) . '"
            ' . implode(" ", $attributes) . '
            ' . (($this->required) ? 'required' : '') . '
            ' . (($this->disabled) ? 'disabled' : '') . '
        >
        ';
    }

    public function required (): static {
        $this->required = true;
        return $this;
    }

    public function disabled (): static {
        $this->disabled = true;
        return $this;
    }

    public function passwordField (): static {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField (): static {
        $this->type = self::TYPE_FILE;
        return $this;
    }

    public function emailField (): static {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    public function telField (): static {
        $this->type = self::TYPE_TEL;
        return $this;
    }

    public function urlField (): static {
        $this->type = self::TYPE_URL;
        return $this;
    }

    public function dateField (): static {
        $this->type = self::TYPE_DATE;
        return $this;
    }

    public function numberField (): static {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }
}