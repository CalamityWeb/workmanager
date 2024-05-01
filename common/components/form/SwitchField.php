<?php

namespace calamity\common\components\form;

use calamity\common\models\core\Calamity;
use calamity\common\models\core\Model;

class SwitchField extends BaseField {
    public function __construct (Model $model, string $attribute, array $options, $disabled) {
        $this->disabled = $disabled;
        parent::__construct($model, $attribute, $options);
    }

    public function renderInput (array $options): string {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        $element = '<div class="form-check form-switch">';
        $element .= '<input  class="form-check-input disabled';
        if (array_key_exists("class", $options)) {
            $element .= $options['class'];
        }
        $element .= $this->model->hasError($this->attribute) ? ' is-invalid"' : '"';
        $element .= ' name="' . $this->attribute . '" ';
        $element .= implode(" ", $attributes);
        $element .= ($this->required) ? ' required' : '';
        $element .= ($this->disabled) ? ' disabled' : '';

        $element .= ' type="checkbox" role="switch"';

        if (!isset($_POST[$this->attribute]) and $this->model->{$this->attribute} and Calamity::$app->request->isPost()) {
            $element .= '>';
        } elseif (isset($_POST[$this->attribute]) or $this->model->{$this->attribute}) {
            $element .= 'checked>';
        } else {
            $element .= '>';
        }

        $element .= '</div>';

        return $element;
    }

    public function disabled (): static {
        $this->disabled = true;
        return $this;
    }
}