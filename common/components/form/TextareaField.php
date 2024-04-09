<?php

namespace calamity\common\components\form;

use calamity\Model;

class TextareaField extends BaseField {
    public function __construct (Model $model, string $attribute, array $options, bool $disabled) {
        $this->disabled = $disabled;
        parent::__construct($model, $attribute, $options);
    }

    public function renderInput (array $options): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        return '
        <textarea
            class="form-control ' . ($this->model->hasError($this->attribute) ? ' is-invalid' : '') . '"
            name="' . $this->attribute . '"
            placeholder="' . $this->model->getLabel($this->attribute) . '"
            ' . implode(" ", $attributes) . '
            ' . (($this->required) ? 'required' : '') . '
            ' . (($this->disabled) ? 'disabled' : '') . '
        >' . $this->model->{$this->attribute} . '</textarea>
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
}