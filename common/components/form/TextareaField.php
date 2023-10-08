<?php

namespace tframe\common\components\form;

use tframe\common\components\form\BaseField;
use tframe\core\Model;

class TextareaField extends BaseField {

    public function __construct(Model $model, string $attribute, array $options) {
        parent::__construct($model, $attribute, $options);
    }

    public function renderInput(array $options): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        return '
        <textarea
            class="form-control ' . ($this->model->hasError($this->attribute) ? ' is-invalid' : '') . '"
            name="' . $this->attribute . '"
            placeholder="' . $this->model->{$this->attribute} . '"
            ' . implode(" ", $attributes) . '
            ' . (($this->required) ? 'required' : '') . '
            ' . (($this->disabled) ? 'disabled' : '') . '
        >
        </textarea>
        ';
    }

    public function required(): static {
        $this->required = true;
        return $this;
    }

    public function disabled(): static {
        $this->disabled = true;
        return $this;
    }
}