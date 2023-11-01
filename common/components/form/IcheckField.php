<?php

namespace tframe\common\components\form;

use tframe\core\Model;

class IcheckField {
    protected Model $model;
    protected string $attribute;
    protected array $options;
    protected string $type;

    protected bool $required = false;
    protected bool $disabled = false;

    public function __construct(Model $model, string $attribute, array $options, bool $disabled) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->options = $options;
        $this->disabled = $disabled;
    }

    public function __toString() {
        return '
        <div class="icheck-primary">
            <input
                type="checkbox"
                id="' . $this->attribute . '"
                name="' . $this->attribute . '" ' .
                (($this->required) ? ' required' : '') . ' ' .
                (($this->disabled) ? ' disabled' : '') . '>
            <label for="' . $this->attribute . '">' . $this->model->getLabel($this->attribute) . '</label>
            <div class="invalid-feedback">
                ' . $this->model->getFirstError($this->attribute) . '
            </div>
        </div>
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