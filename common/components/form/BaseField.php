<?php

namespace calamity\common\components\form;

use calamity\common\models\core\Model;

abstract class BaseField {
    protected Model $model;
    protected string $attribute;
    protected array $options;
    protected string $type;
    protected bool $required = false;
    protected bool $disabled = false;

    public function __construct(Model $model, string $attribute, array $options) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->options = $options;
    }

    public function __toString() {
        return '
        <div class="form-group mb-3">
            <label>' . $this->model->getLabel($this->attribute) . '</label>
            ' . $this->renderInput($this->options) . '
            <div class="invalid-feedback">
                ' . $this->model->getFirstError($this->attribute) . '
            </div>
        </div>
        ';
    }

    abstract public function renderInput(array $options);
}