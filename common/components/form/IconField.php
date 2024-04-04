<?php

namespace tframe\common\components\form;

use tframe\core\Model;

abstract class IconField {
    protected Model $model;
    protected string $attribute;
    protected string $icon;
    protected array $options;
    protected string $type;
    protected bool $required = false;
    protected bool $disabled = false;

    public function __construct (Model $model, string $attribute, string $icon, array $options) {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->icon = $icon;
        $this->options = $options;
    }

    public function __toString () {
        return '
        <div class="input-group">
            ' . $this->renderInput($this->options) . '
            <div class="input-group-text">
                <span class="' . $this->icon . '"></span>
            </div>
        </div>
        <div class="mb-3">
            <span class="text-sm text-danger">' . $this->model->getFirstError($this->attribute) . '</span>
        </div>
        ';
    }

    abstract public function renderInput (array $options);
}