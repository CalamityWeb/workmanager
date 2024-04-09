<?php

namespace calamity\common\components\form;

use calamity\Model;

class SelectField extends BaseField {
    private array $choices;
    private bool $canBeNull;

    public function __construct (Model $model, string $attribute, array $options, array $choices, bool $canBeNull, bool $disabled) {
        $this->choices = $choices;
        $this->canBeNull = $canBeNull;
        $this->disabled = $disabled;
        parent::__construct($model, $attribute, $options);
    }

    public function renderInput (array $options): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $element = '<select class="form-select ';
        if (array_key_exists("class", $options)) {
            $element .= $options['class'];
        }
        $element .= $this->model->hasError($this->attribute) ? ' is-invalid"' : '"';
        $element .= ' name="' . $this->attribute . '" ';
        $element .= implode(" ", $attributes);
        $element .= ($this->required) ? ' required' : '';
        $element .= ($this->disabled) ? ' disabled>' : '>';

        if ($this->canBeNull) $element .= '<option value="null">(not set)</option>';

        foreach ($this->choices as $key => $value) {
            $element .= '<option value="' . $key . '"';
            $element .= ($_POST[$this->attribute] == $key or $this->model->{$this->attribute} == $key) ? ' selected>' : '>';
            $element .= $value . '</option>';
        }

        $element .= '</select>';

        return $element;
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